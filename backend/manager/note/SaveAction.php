<?php

namespace backend\manager\note;

use backend\models\Note;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class SaveAction
 * @package backend\manager\note
 * @User:五更的猫
 * @DateTime: 2023/12/13 16:25
 * @TODO 设置是否公开
 */
class SaveAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);
        $is_open = $this->RequestData('is_open',null);

        if(empty($id)){
            throw new ApiException('请选择客户笔记',1);
        }
        if(empty($is_open)){
            throw new ApiException('请选择公开状态',1);
        }

        $model = Note::findOne(['id'=>$id]);
        if(empty($model)){
            throw new ApiException('未找到此客户笔记',1);
        }

        $model->is_open = $is_open;

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id']=$model->id;

        return $jsonData;
    }

}