<?php

namespace backend\controllers;

use backend\actions\SortAction;
use backend\models\Book;
use backend\models\BookDetail;
use backend\models\TeamBook;
use backend\models\UserCheck;
use backend\models\UserTeam;
use Yii;
use backend\search\TeamSearch;
use backend\models\Team;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;

/**
 * TeamController implements the CRUD actions for Team model.
 */
class TeamController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => Team::className(),
                'data' => function(){
                    
                        $searchModel = new TeamSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Team::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Team::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Team::className(),
            ],
        ];
    }

    public function actionUser(){
        $id=Yii::$app->request->get('id');

        return $this->redirect(['user-team/index','id'=>$id]);

    }


    public function actionTask2(){
        $id=Yii::$app->request->get('id');
        $user=UserTeam::find()->where(['team_id'=>$id])->all();
        $model=Team::findOne($id);
        if($model->status!=1){
            return $this->message('已经开始读了',$this->redirect(Yii::$app->request->referrer),'error');
        }
        if(count($user)<=0){
            return $this->message('请至少添加一个成员',$this->redirect(Yii::$app->request->referrer),'error');
        }else{
            $book=Book::findOne($model['book_id']);
            if(!$book){
                return $this->message('请选择要读的书籍',$this->redirect(Yii::$app->request->referrer),'error');
            }
            $detail=BookDetail::find()->where(['book_id'=>$book['id']])->all();
            foreach ($detail as $k=>$v){
                if($v['day']>0 and $v['content']){
                    foreach ($user as $k2=>$v2){
                        $new=new UserCheck();
                        $new->user_id=$v2['user_id'];
                        $new->book_id=$v['book_id'];
                        $new->detail_id=$v['id'];
                        $new->type=$model['type'];
                        $new->relation_id=$model['id'];
                        $new->time=strtotime(date('Y-m-d'))+($v['day']-1)*24*3600;
                        if(!$new->save()){
                            print_r($new->getFirstErrors());exit();
                        }
                    }

                }
            }
            $model->status=2;
            $model->save();
            return $this->message('成功',$this->redirect(Yii::$app->request->referrer),'success');
        }


    }


    public function actionTask3(){
        $id=Yii::$app->request->get('id');
        $model=Team::findOne($id);
        $book=Book::findOne($model['book_id']);
        if(!$book){
            return $this->message('请选择要读的书籍',$this->redirect(Yii::$app->request->referrer),'error');
        }
        $time=Yii::$app->request->get('start_time');

        $user=UserTeam::find()->where(['team_id'=>$id])->all();
        $detail=BookDetail::find()->where(['book_id'=>$book['id']])->all();
        TeamBook::deleteAll(['team_id'=>$id,'book_id'=>$book['id']]);
        foreach ($detail as $k=>$v){
                if($v['day']>0 and $v['content']){
                    $new=new TeamBook();
                    $new->book_id=$book['id'];
                    $new->detail_id=$v['id'];
                    $new->time=strtotime($time)+($v['day']-1)*24*3600;
                    $new->team_id=$model->id;
                    $new->save();
                    foreach ($user as $k2=>$v2){
                        $old=UserCheck::find()->where(['book_id'=>$v['book_id'],'relation_id'=>$model['id'],'detail_id'=>$v['id'],'user_id'=>$v2['user_id']])->limit(1)->one();
                        if($old){
                            $old->time=strtotime($time)+($v['day']-1)*24*3600;
                        }else{
                            $new=new UserCheck();
                            $new->user_id=$v2['user_id'];
                            $new->book_id=$v['book_id'];
                            $new->detail_id=$v['id'];
                            $new->type=$model['type'];
                            $new->relation_id=$model['id'];
                            $new->time=strtotime($time)+($v['day']-1)*24*3600;
                            if(!$new->save()){
                                print_r($new->getFirstErrors());exit();
                            }
                        }

                    }

                }
            }

        $models=TeamBook::find()->where(['book_id'=>$book['id'],'team_id'=>$id])->orderBy('time asc')->all();
        return $this->render('task',['models'=>$models]);

    }



    public function actionTask(){
        $id=Yii::$app->request->get('id');
        $model=Team::findOne($id);
        $book=Book::findOne($model['book_id']);
        if(!$book){
            return $this->message('请选择要读的书籍',$this->redirect(Yii::$app->request->referrer),'error');
        }

        $user=UserTeam::find()->where(['team_id'=>$id])->all();
        $detail=BookDetail::find()->where(['book_id'=>$book['id']])->all();
        $count=TeamBook::find()->where(['team_id'=>$id,'book_id'=>$book['id']])->count();
        if($count==0){
            foreach ($detail as $k=>$v){
                if($v['day']>0 and $v['content']){
                    $old_message=TeamBook::find()->where(['book_id'=>$book['id'],'detail_id'=>$v['id'],'team_id'=>$model['id']])->all();
                    foreach ($old_message as $k2=>$v2){
                        $v2->delete();
                    }
                    $new=new TeamBook();
                    $new->book_id=$book['id'];
                    $new->detail_id=$v['id'];
                    $new->time=strtotime(date('Y-m-d'))+($v['day']-1)*24*3600;
                    $new->team_id=$model->id;
                    $new->save();
                    foreach ($user as $k2=>$v2){
//                        $message2=UserCheck::find()->where(['book_id'=>$v['book_id'],'relation_id'=>$model['id'],'detail_id'=>$v['id'],'user_id'=>$v2['user_id']])->all();
//                        foreach ($message2 as $k3=>$v3){
//                            if($v3['status']==1){
//                                $v3->delete();
//                            }
//                        }
                        $old=UserCheck::find()->where(['book_id'=>$v['book_id'],'relation_id'=>$model['id'],'detail_id'=>$v['id'],'user_id'=>$v2['user_id']])->limit(1)->one();
                        if($old){
                            $old->time=strtotime(date('Y-m-d'))+($v['day']-1)*24*3600;
                        }else{
                            $new=new UserCheck();
                            $new->user_id=$v2['user_id'];
                            $new->book_id=$v['book_id'];
                            $new->detail_id=$v['id'];
                            $new->type=$model['type'];
                            $new->relation_id=$model['id'];
                            $new->time=strtotime(date('Y-m-d'))+($v['day']-1)*24*3600;
                            if(!$new->save()){
                                print_r($new->getFirstErrors());exit();
                            }
                        }

                    }

                }
            }
        }else{
            $team_book=TeamBook::find()->where(['team_id'=>$id,'book_id'=>$book['id']])->all();
            foreach ($team_book as $k=>$v){
                    foreach ($user as $k2=>$v2){
                        $old=UserCheck::find()->where(['book_id'=>$v['book_id'],'relation_id'=>$model['id'],'user_id'=>$v2['user_id'],'detail_id'=>$v['detail_id']])->limit(1)->one();
                        if($old){
                            $old->time=$v['time'];
                        }else{
                            $new=new UserCheck();
                            $new->user_id=$v2['user_id'];
                            $new->book_id=$v['book_id'];
                            $new->detail_id=$v['detail_id'];
                            $new->type=$model['type'];
                            $new->relation_id=$model['id'];
                            $new->time=$v['time'];
                            if(!$new->save()){
                                print_r($new->getFirstErrors());exit();
                            }
                        }
                    }
            }
        }

        $models=TeamBook::find()->where(['book_id'=>$book['id'],'team_id'=>$id])->orderBy('time asc')->all();
        return $this->render('task',['models'=>$models]);

    }



    public function actionBook(){
        $book=Yii::$app->request->get('book');
        foreach ($book as $k=>$v){
            $model=TeamBook::findOne($k);
            if($model){
                $model->time=strtotime($v);
                $model->save();
                $check=UserCheck::find()->where(['book_id'=>$model->book_id,'relation_id'=>$model['team_id'],'detail_id'=>$model['detail_id']])->all();
                foreach ($check as $k2=>$v2){
                    $v2->time=$model->time;
                    $v2->save();
                }
            }
        }
        return $this->render('/layer/close');
    }



}
