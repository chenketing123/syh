<?php

namespace backend\controllers;
use common\components\Helper;
use Yii;
use backend\search\UserSearch;
use backend\models\User;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\models\UploadForm;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => User::className(),
                'data' => function(){
                    
                        $searchModel = new UserSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                    $add=new UploadForm();
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                        'add'=>$add,
                    ];

                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => User::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => User::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => User::className(),
            ],
        ];
    }


    public function actionDaoru(){
        $add=new UploadForm();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (isset($post['UploadForm']['file'])) {
                if (UploadedFile::getInstance($add, 'file')) {
                    $add->file = UploadedFile::getInstances($add, 'file')[0];
                    if ($add->file && $add->validate()) {
                        $name = '../uploads/' . time() . 'test' . '.' . $add->file->extension;
                        $add->file->saveAs($name);
                        //导入数据库
                        $url = $name;
                        $return = Helper::import_excel($url);
                        $count=count($return);
                        if($count>10000){
                            return $this->message('一次导入不要超过10000',$this->redirect(Yii::$app->request->referrer),'error');
                        }
                        $err=[];
                        //每条数据需要检测
                        foreach ($return as $k=>$v){

                            $user=User::findOne(['mobile_phone'=>$v[16]]);
                            if($user or !$v[16]){
                                if(!$v[16]){
                                    $error='手机号码必填';
                                    $err[]=$error;
                                }else{
                                    $error=$v[16].'用户已存在';
                                    $err[]=$error;
                                }

                            }else{
                               $new=new User();
                               $new->dmts=$v[1];
                               $new->fhmc=$v[2];
                               $new->hubh=$v[3];
                               $new->snzy=$v[4];
                               $new->name=$v[5];
                               $new->zw=$v[6];
                               $new->sex_value=$v[7];
                               $new->id_card=$v[8];
                               $new->zb=$v[9];
                               $new->company=$v[10];
                               $new->csny=Helper::jieExcelDate($v['11']);
                               $new->year=$v[12];
                               $new->month=$v[13];
                               $new->day=$v[14];
                               $new->jl=$v[15];
                               $new->mobile_phone=(string)$v[16];
                               $new->xsskc=$v[17];
                               $new->xl=$v[18];
                               $new->scjf=Helper::jieExcelDate($v['19']);
                               $new->yf=$v[20];
                               $new->hfdq=Helper::jieExcelDate($v['21']);
                               $new->is_vip=1;
                                $new->nxse=$v[22];
                                $new->ygs=$v[23];
                                $new->hy=$v[24];
                                $new->goods=$v[25];
                                $new->sfss=$v[26];
                                $new->sssj=$v[27];
                                $new->email=$v[28];
                                $new->gsqy=$v[29];
                                $new->gsdz=$v[30];
                                $new->sjrdz=$v[31];
                                $new->sjrxm=$v[32];
                                $new->sjrdh=$v[33];
                                $new->tjr=$v[34];
                                $new->jjlxr=$v[35];
                                $new->qylxr=$v[36];
                                $new->sfkp=$v[37];
                                $new->kpzl=$v[38];
                                $new->dytj=$v[39];
                                if(!$new->save()){
                                    $message=$new->getFirstErrors();
                                    $err[]=$v[16].reset($message);
                                }


                            }
                        }
                        if(count($err)>0){
                            print_r($err);
                            exit();
                        }
                    }
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
