<?php

namespace backend\manager\TextTask;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\TextTask;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class EditAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);
        $title = $this->RequestData('title','');
        $sort = $this->RequestData('sort',10);
        $status = $this->RequestData('status',1);


        if(empty($title)){
            throw new ApiException('标题不能为空',1);
        }

  
        $model = TextTask::findOne($id);
        if(empty($model)){
            $model = new TextTask();
        }
        $model->title = $title;
        $model->sort = $sort;
        $model->status = $status;
  
 

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}