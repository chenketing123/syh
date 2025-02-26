<?php

namespace backend\manager\Market;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\Market;


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
        $manager = $this->RequestData('manager','');
        $province = $this->RequestData('province',0);

  
        $model = Market::findOne($id);
        if(empty($model)){
            $model = new Market;
        }

        $model->title = $title;
        $model->manager = $manager;
        $model->province = $province;
  
 

 
 
        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;




    }

}