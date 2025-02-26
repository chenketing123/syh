<?php

namespace backend\controllers;

use backend\models\User;
use backend\models\UserCheck;
use Yii;
use backend\search\UserTeamSearch;
use backend\models\UserTeam;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use yii\base\BaseObject;
use yii\data\ActiveDataProvider;

/**
 * UserTeamController implements the CRUD actions for UserTeam model.
 */
class UserTeamController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => UserTeam::className(),
                'data' => function(){

                        $id=Yii::$app->request->get('id');
                    $query=UserTeam::find()->where(['team_id'=>$id]);
                    $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'sort' => [
                            'defaultOrder' => [
                                'sort'=>SORT_ASC,
                                'id'=>SORT_DESC,
                            ]
                        ],
                    ]);
                        return [
                            'dataProvider' => $dataProvider,
                            'id'=>$id
                        ];

                }
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => UserTeam::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => UserTeam::className(),
            ],
        ];
    }


    public function actionCreate(){
        $team_id=Yii::$app->request->get('team_id');
        $model=new UserTeam();
        $model->team_id=$team_id;
        if (yii::$app->getRequest()->getIsPost()) {
            $post=Yii::$app->request->post('UserTeam');
            $type=$model['type'];
            if(!$type){
                $type=1;
            }
            if($type==1){
                $type_value='小组';
            }else{
                $type_value='团队';
            }
            foreach ($post['user_ids'] as $k=>$v){

                $user_team=UserTeam::find()->where(['user_id'=>$v,'type'=>$type])->limit(1)->one();
                $user_now=User::findOne($v);
                if($user_team){
                    $err='用户'.$user_now['mobile_phone'].'已经加入别的'.$type_value;
                    Yii::$app->getSession()->setFlash('error', $err);
                    $model->loadDefaultValues();
                    $data = [
                        'model' => $model,
                    ];
                    return $this->render('create', $data);
                }

            }

            foreach ($post['user_ids'] as $k=>$v){
                $new=new UserTeam();
                $new->team_id=$team_id;
                $new->user_id=$v;
                $new->type=$type;
                $new->sort=$post['sort'];
                $new->save();
            }
            return $this->render('/layer/close');
        }
        $model->loadDefaultValues();
        $data = [
            'model' => $model,
        ];
        return $this->render('create', $data);
    }

}
