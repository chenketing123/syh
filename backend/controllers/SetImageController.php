<?php

namespace backend\controllers;

use common\components\Helper;
use Yii;
use backend\search\SetImageSearch;
use backend\models\SetImage;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use yii\web\UploadedFile;

/**
 * SetImageController implements the CRUD actions for SetImage model.
 */
class SetImageController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => SetImage::className(),
                'data' => function(){
                    
                        $searchModel = new SetImageSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'index2' => [
                'class' => IndexAction::className(),
                'modelClass' => SetImage::className(),
                'data' => function(){

                    $searchModel = new SetImageSearch();
                    $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ];

                }
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => SetImage::className(),
            ],
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    //图片
                    "imageUrlPrefix" => Yii::getAlias("@attachurl"),//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}/{mm}/{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => Yii::getAlias("@attachment"),//根目录地址
                    //视频
                    "videoUrlPrefix" => Yii::getAlias("@attachurl"),
                    "videoPathFormat" => "/upload/video/{yyyy}/{mm}/{dd}/{time}{rand:6}",
                    "videoRoot" => Yii::getAlias("@attachment"),
                    //文件
                    "fileUrlPrefix" => Yii::getAlias("@attachurl"),
                    "filePathFormat" => "/upload/file/{yyyy}/{mm}/{dd}/{time}{rand:6}",
                    "fileRoot" => Yii::getAlias("@attachment"),
                ],
            ]
        ];
    }

    public function actionCreate(){
        $model=new SetImage();
        $model->loadDefaultValues();
            if (Yii::$app->getRequest()->getIsPost()) {
                $model->file = UploadedFile::getInstance($model, "file");
                if(isset($model->file->baseName)){
                    $size=ceil($model->file->size/1024/1024*1000)/1000;
                    $name='/uploads/' .date('Ymdhis'). Helper::random(6) . '.' . $model->file->extension;
                    $name2='..' .$name;
                    $model->file->saveAs($name2);
                    $model->file_value=$name;
                    $model->up_time=time();
                    $model->file_size=$size;
                }
                if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
                    if( yii::$app->getRequest()->getIsAjax() ){
                        return [];
                    }else {
                        return $this->render('/layer/close');
                    }
                } else {
                    $errors = $model->getErrors();
                    $err = '';
                    foreach ($errors as $v) {
                        $err .= $v[0] . '<br>';
                    }
                    yii::$app->getSession()->setFlash('error', $err);
                }
            }
            return $this->render('create', ['model'=>$model]);
    }
    public function actionUpdate(){
        $model=SetImage::findOne(Yii::$app->request->get('id'));
        if($model){
            if (Yii::$app->getRequest()->getIsPost()) {
                $model->file = UploadedFile::getInstance($model, "file");
                if(isset($model->file->baseName)){
                    $size=ceil($model->file->size/1024/1024*1000)/1000;
                    $name='/uploads/' .date('Ymdhis'). $model->file->baseName . '.' . $model->file->extension;
                    $name2='..' .$name;
                    $model->file->saveAs($name2);
                    $model->file_value=$name;
                    $model->up_time=time();
                    $model->file_size=$size;
                }
                if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
                    if( yii::$app->getRequest()->getIsAjax() ){
                        return [];
                    }else {
                        return $this->render('/layer/close');
                    }
                } else {
                    $errors = $model->getErrors();
                    $err = '';
                    foreach ($errors as $v) {
                        $err .= $v[0] . '<br>';
                    }
                    yii::$app->getSession()->setFlash('error', $err);
                }
            }
            return $this->render('update', ['model'=>$model]);
        }
    }






    public function actionSingle(){
        $model=SetImage::getOne(['type'=>Yii::$app->request->get('type'),'language'=>Yii::$app->language]);
        if($model){
            if (yii::$app->getRequest()->getIsPost()) {
                $model->file = UploadedFile::getInstance($model, "file");
                if(isset($model->file->baseName)){
                    $name='/uploads/' .date('Ymdhis'). $model->file->baseName . '.' . $model->file->extension;
                    $name2='..' .$name;
                    $model->file->saveAs($name2);
                    $model->file_value=$name;
                }
                if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
                    if( yii::$app->getRequest()->getIsAjax() ){
                        return [];
                    }else {
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                } else {
                    $errors = $model->getErrors();
                    $err = '';
                    foreach ($errors as $v) {
                        $err .= $v[0] . '<br>';
                    }
                    yii::$app->getSession()->setFlash('error', $err);
                }
            }
            return $this->render('single', ['model'=>$model]);
        }
    }







}
