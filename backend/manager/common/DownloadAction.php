<?php

namespace backend\manager\common;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\Download;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class DownloadAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {
        $request  = Yii::$app->request;
        $download_type = $this->RequestData('download_type',0);

        if(!isset(Download::$type[$download_type])){
            throw new ApiException('导出任务类型错误',1);
        }

        if(Download::addLog($download_type,$request->get())){

            throw new ApiException('导出任务生成，请在导出记录里查看下载',1);

        }else{
            throw new ApiException('导出任务生成失败'.$download_type,1);
        }


    }

}