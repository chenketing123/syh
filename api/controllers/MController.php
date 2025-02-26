<?php
namespace api\controllers;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\SetImage;
use Yii;
use common\controllers\BaseController;
use yii\base\BaseObject;

class MController extends BaseController
{
    public          $enableCsrfValidation = false;//csrf验证
    public          $_pageSize = 20;        //分页大小
    public          $UserInfo=array();
    /**
     * @inheritdoc
     * 独立动作
     */
    public function actions()
    {
        return [
            //错误提示跳转页面
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 自动运行
     */
    public function  init()
    {

        Activity::updateAll(['status'=>2],['and',['status'=>1],['<=','end_time',time()]]);
        Activity::updateAll(['status'=>2],['and',['status'=>3],['<=','end_time',time()]]);



        parent::init();

//        header("Access-Control-Allow-Origin: *");
//        //header("Access-Control-Allow-Credentials : true");
//        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie");

    }

}