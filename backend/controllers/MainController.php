<?php
/**
 * Created by PhpStorm.
 * User: 简言
 * Date: 2016/3/22
 * Time: 9:04
 * 主控制器
 */
namespace backend\controllers;

use backend\models\CgOrder;
use backend\models\PlaceOrder;
use Yii;
use backend\models\Manager;

class MainController extends MController
{
    /**
     * 主体框架
     */
    public function actionIndex()
    {
        //用户ID
        $id     = Yii::$app->user->identity->id;
        $user   = Manager::find()
            ->where(['id'=>$id])
            ->with('assignment')
            ->one();
        return $this->renderPartial('index',[
            'user'  => $user,
        ]);
    }

    /**
     * 系统首页
     */
    public function actionSystem()
    {
        return $this->render('system',[

        ]);
    }

    //切换语言
    public function actionLanguage(){
        $language=Yii::$app->request->get('language');
        Yii::$app->session->set('language',$language);
        return $this->redirect(Yii::$app->request->referrer);
    }

}