<?php

namespace backend\controllers;

use common\components\Helper;
use dosamigos\qrcode\QrCode;
use http\Url;
use moonland\phpexcel\Excel;
use Yii;
use backend\search\CodeSearch;
use backend\models\Code;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use yii\base\Object;

/**
 * CodeController implements the CRUD actions for Code model.
 */
class CodeController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => Code::className(),
                'data' => function(){
                    
                        $searchModel = new CodeSearch();
                        $searchModel->type=1;
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],

            'index2' => [
                'class' => IndexAction::className(),
                'modelClass' => Code::className(),
                'data' => function(){

                    $searchModel = new CodeSearch();
                    $searchModel->type=2;
                    $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ];

                }
            ],


            'index3' => [
                'class' => IndexAction::className(),
                'modelClass' => Code::className(),
                'data' => function(){

                    $searchModel = new CodeSearch();
                    $searchModel->type=3;
                    $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ];

                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Code::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Code::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Code::className(),
            ],
        ];
    }


    public function actionCode(){
        ini_set('memory_limit', '2048M');
        set_time_limit(0);
        $name=date('Ymd').'zip';
        $cache=Yii::$app->cache->get($name);
        if($cache){

            Yii::$app->cache->set($name,$cache+1);
            $cache++;
        }else{
            $cache=1;
            Yii::$app->cache->set($name,1);
        }

        $zipPath=Yii::getAlias("@attachment").'/'.date('Ymd').$cache.'.zip';
        $i=1;
        $arr_image=[];
        while ($i<=500){
            $now=$i+($cache-1)*500;
            $content_now=date('Ymd').$now.Helper::random(10);
            $content=Yii::$app->params['web_url'].'/index.php/test.html?qr_code='.$content_now;
            $new=new Code();
            $new->value=$content_now;
            $new->created_at=time();
            $new->save();
            ob_start();
            QRcode::png($content, false, 'L', 10, 1);
            $img = ob_get_contents();
            ob_end_clean();
            $imgInfo = 'data:image/jpeg;base64,' . chunk_split(base64_encode($img));//תbase64
            ob_flush();
            Helper::base64_image_content2($imgInfo,$content_now);
            $arr_image[]= Yii::getAlias("@attachment") . "/" .date('Ymd').'/'.$content_now.'.jpeg';
            $i++;
        }
        $zip=new \ZipArchive();

        $zip->open($zipPath,\ZipArchive::CREATE);
        foreach ($arr_image as $k=>$v){
            $zip->addFile($v,basename(str_replace('Yii::getAlias("@attachment")','',$v)));
        }
        $zip->close();
        $url='/attachment'.'/'.date('Ymd').$cache.'.zip';
        return $this->redirect($url);


    }


    public function actionCode2(){
        $i=1;
        $id=0;
        while ($i<=10000){
            $content_now=date('Ymd').$i.Helper::random(10);
            $new=new Code();
            $new->value=$content_now;
            $new->created_at=time();
            $new->save();
            if($i==1){
                $id=$new->id;
            }
            $i++;
        }
        $model=Code::find()->where(['>=','id',$id])->orderBy('id asc')->all();
        Excel::export([
            'models' =>$model,
            'fileName' => '二维码'.date('Y-m-d').'.xlsx',
            'columns' => [

                [
                    'header' => '链接',
                    'value' =>function($data){
                        return Yii::$app->params['web_url'].'/index.php/test.html?qr_code='.$data->value;
                    }
                ],

            ]
        ]);

        return $this->redirect(\yii\helpers\Url::to(['code/index']));
    }



    public function actionCode3(){
        $i=1;
        $id=0;
        while ($i<=10000){
            $content_now=date('Ymd').$i.Helper::random(10);
            $new=new Code();
            $new->value=$content_now;
            $new->created_at=time();
            $new->type=2;
            $new->save();
            if($i==1){
                $id=$new->id;
            }
            $i++;
        }
        $model=Code::find()->where(['>=','id',$id])->orderBy('id asc')->all();
        Excel::export([
            'models' =>$model,
            'fileName' => '二维码'.date('Y-m-d').'.xlsx',
            'columns' => [

                [
                    'header' => '链接',
                    'value' =>function($data){
                        return Yii::$app->params['web_url'].'/index.php/test.html?qr_code='.$data->value;
                    }
                ],

            ]
        ]);

        return $this->redirect(\yii\helpers\Url::to(['code/index2']));
    }



    public function actionCode4(){
        $i=1;
        $id=0;
        while ($i<=10000){
            $content_now=date('Ymd').$i.Helper::random(10);
            $new=new Code();
            $new->value=$content_now;
            $new->created_at=time();
            $new->type=3;
            $new->save();
            if($i==1){
                $id=$new->id;
            }
            $i++;
        }
        $model=Code::find()->where(['>=','id',$id])->orderBy('id asc')->all();
        Excel::export([
            'models' =>$model,
            'fileName' => '二维码'.date('Y-m-d').'.xlsx',
            'columns' => [

                [
                    'header' => '链接',
                    'value' =>function($data){
                        return Yii::$app->params['web_url'].'/index.php/test.html?qr_code='.$data->value;
                    }
                ],

            ]
        ]);

        return $this->redirect(\yii\helpers\Url::to(['code/index3']));
    }
}
