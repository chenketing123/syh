<?php

namespace backend\manager\UploadBatch;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\UserHandover;
use backend\models\UploadBatch;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class AddAction extends ManagerApiAction
{
    protected function runAction()
    {

        $type = $this->RequestData('type','');
        $files = $this->RequestData('files','');
 
 
        if(empty($files)){
            throw new ApiException('请上传文件',1);
        }

        $model = new UploadBatch;
        $model->type = $type;
        $model->files = CommonFunction::unsetImg($files);
 


        if (!$model->save()) {
            $error = $model->getErrors();
            $error = reset($error);
            $error = reset($error);

            throw new ApiException($error,1);

        }
 
 
 



    }

}