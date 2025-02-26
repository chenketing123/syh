<?php

namespace backend\controllers;

use backend\models\User;
use backend\models\UserType;
use common\components\Helper;
use moonland\phpexcel\Excel;
use Yii;
use backend\search\HistorySearch;
use backend\models\History;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use backend\models\UploadForm;
use yii\base\Object;
use yii\web\UploadedFile;

/**
 * HistoryController implements the CRUD actions for History model.
 */
class HistoryController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => History::className(),
                'data' => function(){
                    
                        $searchModel = new HistorySearch();
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
                'modelClass' => History::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => History::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => History::className(),
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
                            if($v[0]){
                                $new= New History();
                                $new->code=(string)$v[0];
                                $new->name=(string)$v[1];
                                $new->time=strtotime(Helper::jieExcelDate($v[2]));

            $return=Helper::gps_to_map($v[3],$v[4],'baidu');
            if($return['status']==1){
                $location=explode(',',$return['locations']);
                $new->lng=$location[0];
                $new->lat=$location[1];

            }

//                                $new->lng=$v[3];
//                                $new->lat=$v[4];
                                $new->number1=$v[5];
                                $new->number2=$v[6];
                                $new->number3=$v[7];
                                $new->number4=$v[8];
                                $new->number5=$v[9];
                                $new->number6=$v[10];
                                $new->number7=$v[11];
                                $new->date=date('Ymd',$new->time);
                                if(!$new->save()){
                                    $error=$new->getFirstErrors();
                                    $v[2]=Helper::jieExcelDate($v[2]);
                                    $v[12]=reset($error);
                                    $err[]=$v;
                                }
                            }


                        }
                        if(count($err)>0){
                            Excel::export([
                                'models' =>$err,
                                'fileName'=>'错误数据',
                                'columns' => [
                                    [
                                        'attribute'=>'0',
                                        'header'=>'设备编号'
                                    ],
                                    [
                                        'attribute'=>'1',
                                        'header'=>'点位名称'
                                    ],
                                    [
                                        'attribute'=>'2',
                                        'header'=>'时间'
                                    ],
                                    [
                                        'attribute'=>'3',
                                        'header'=>'温度'
                                    ],
                                    [
                                        'attribute'=>'4',
                                        'header'=>'盐度(%)'
                                    ],
                                    [
                                        'attribute'=>'5',
                                        'header'=>'PH值'
                                    ],
                                    [
                                        'attribute'=>'6',
                                        'header'=>'叶绿素'
                                    ],
                                    [
                                        'attribute'=>'7',
                                        'header'=>'油类'
                                    ],
                                    [
                                        'attribute'=>'8',
                                        'header'=>'深度(m)'
                                    ],
                                    [
                                        'attribute'=>'9',
                                        'header'=>'浊度(NTU)'
                                    ],
                                    [
                                        'attribute'=>'10',
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


    //导出
    public function actionDaochu()
    {
        ini_set('memory_limit', '3072M');    // 临时设置最大内存占用为3G
        set_time_limit(0);
        $search = new HistorySearch();
        $url = Yii::$app->request->referrer;
        $data = $search->search(Yii::$app->request->get('message'));
        $count = $data->query->count();
        if ($count == 0) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        if ($count > 50000) {
            return $this->message('每次最多导出50000条数据', $this->redirect(Yii::$app->request->referrer), 'error');
        }

        $model = $data->query->orderBy('id desc')->all();

        Excel::export([
            'models' => $model,
            'fileName' =>  date('Y-m-d') . '.xlsx',
            'columns' => [

                [
                    'attribute' => 'code',

                ],
                [
                    'attribute' => 'name',

                ],
                [
                    'attribute' => 'lng',

                ],
                [
                    'attribute' => 'lat',

                ],
                [
                    'attribute' => 'number1',

                ],
                [
                    'attribute' => 'number2',

                ],
                [
                    'attribute' => 'number3',

                ],
                [
                    'attribute' => 'number4',

                ],
                [
                    'attribute' => 'number5',

                ],
                [
                    'attribute' => 'number6',

                ],
                [
                    'attribute' => 'number7',

                ],
                'time:datetime',
            ]
        ]);
        return $this->redirect(Yii::$app->request->referrer);
    }

}
