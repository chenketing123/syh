<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\models\Manager;
use backend\models\LoginForm;

/**
 * 站点控制器
 */
class SiteController extends Controller
{
    //默认布局文件
    public $layout = "site";

    /**
     * @inheritdoc
     * 错误提示跳转页面
     */
    public function actions()
    {


        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            //验证码
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 5,       //最大显示个数
                'minLength' => 5,       //最少显示个数
                'padding' => 5,       //间距
                'height' => 32,       //高度
                'width' => 100,     //宽度
                'offset' => 4,       //设置字符偏移量 有效果
                //'backColor' =>0x000000,//背景颜色
                //'foreColor' =>0xffffff, //字体颜色

            ],
            //图片上传
            'webupload' => 'yidashi\webuploader\Action',
        ];
    }

    /**
     * 行为控制
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'captcha', 'test'],
                        'allow' => true,
                        'roles' => ['?'],//游客
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],//登录
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * 登陆
     */
    public function actionLogin()
    {


        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //插入日志
            Yii::$app->actionlog->addLog(1, "manager");

            //更新用户登陆
            Manager::upLoginInfo();

            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return \yii\web\Response
     * 退出登陆
     */
    public function actionLogout()
    {
        //插入日志
        Yii::$app->actionlog->addLog(2, "manager");

        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }

}
