<?php

namespace backend\controllers;

use common\components\Helper;
use moonland\phpexcel\Excel;
use Yii;
use backend\search\StreamSearch;
use backend\models\Stream;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\models\UploadForm;
use yii\base\Object;
use yii\web\UploadedFile;

/**
 * StreamController implements the CRUD actions for Stream model.
 */
class StreamController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => Stream::className(),
                'data' => function(){
                    
                        $searchModel = new StreamSearch();
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
                'modelClass' => Stream::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Stream::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Stream::className(),
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
                                $new= New Stream();
                                $new->name=(string)$v[0];
                                $new->lng=$v[1];
                                $new->lat=$v[2];
                                $new->area=(string)$v[3];
                                $new->address=(string)$v[4];
                                $new->number=$v[5];
                                $new->level=$v[6];
                                $new->river_system=$v[7];
                                $new->street=$v[8];
                                $new->maintenance=$v[9];
                                $new->area_2=$v[10];
                                if(!$new->save()){
                                    $error=$new->getFirstErrors();
                                    $v[11]=reset($error);
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
                                        'header'=>'经度'
                                    ],
                                    [
                                        'attribute'=>'2',
                                        'header'=>'纬度'
                                    ],
                                    [
                                        'attribute'=>'3',
                                        'header'=>'区域'
                                    ],
                                    [
                                        'attribute'=>'4',
                                        'header'=>'详细地址'
                                    ],
                                    [
                                        'attribute'=>'5',
                                        'header'=>'点位数量(数字)'
                                    ],
                                    [
                                        'attribute'=>'6',
                                        'header'=>'河道等级'
                                    ],
                                    [
                                        'attribute'=>'7',
                                        'header'=>'水系'
                                    ],
                                    [
                                        'attribute'=>'8',
                                        'header'=>'所属街道'
                                    ],
                                    [
                                        'attribute'=>'9',
                                        'header'=>'维护单位'
                                    ],
                                    [
                                        'attribute'=>'10',
                                        'header'=>'面积(km²)'
                                    ],
                                    [
                                        'attribute'=>'11',
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
