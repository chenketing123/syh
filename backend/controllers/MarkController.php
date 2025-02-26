<?php

namespace backend\controllers;

use common\components\Helper;
use moonland\phpexcel\Excel;
use Yii;
use backend\search\MarkSearch;
use backend\models\Mark;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\models\UploadForm;
use yii\base\Object;
use yii\web\UploadedFile;

/**
 * MarkController implements the CRUD actions for Mark model.
 */
class MarkController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => Mark::className(),
                'data' => function(){
                    
                        $searchModel = new MarkSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        $add = new UploadForm();
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                            'add'=>$add
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Mark::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Mark::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Mark::className(),
            ],
        ];
    }


    //导入
    public function actionDaoru(){
        $add=new UploadForm();
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (isset($post['UploadForm']['file'])) {
                if (UploadedFile::getInstance($add, 'file')) {
                    $add->file = UploadedFile::getInstances($add, 'file')[0];
                    if ($add->file && $add->validate()) {
                        $name = '../uploads/' . time() . 'terminal' . '.' . $add->file->extension;
                        $add->file->saveAs($name);
                        //导入数据库
                        $url = $name;
                        $return = Helper::import_excel($url);
                        $err=[];
                        //每条数据需要检测，故无法批量导入
                        foreach ($return as $k=>$v){
                            $new= New Mark();
                            $new->stream=(string)$v[0];
                            $new->code=(string)$v[1];
                            $new->name=(string)$v[2];
                            $new->lng=$v[3];
                            $new->lat=$v[4];
                            if(!$new->save()){
                                $error=$new->getFirstErrors();
                                $v[5]=reset($error);
                                $err[]=$v;
                            }

                        }
                        if(count($err)>0){
                            Excel::export([
                                'models' =>$err,
                                'fileName'=>'错误数据',
                                'columns' => [
                                    [
                                        'attribute'=>'0',
                                        'header'=>'河道名称'
                                    ],
                                    [
                                        'attribute'=>'1',
                                        'header'=>'设备编号'
                                    ],
                                    [
                                        'attribute'=>'2',
                                        'header'=>'点位名称'
                                    ],
                                    [
                                        'attribute'=>'3',
                                        'header'=>'经度'
                                    ],
                                    [
                                        'attribute'=>'4',
                                        'header'=>'纬度'
                                    ],
                                    [
                                        'attribute'=>'5',
                                        'header'=>'错误原因'
                                    ],
                                ],
                            ]);

                        }
                    }
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
