<?php

namespace backend\manager\note;

use backend\models\Note;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class SaveAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 14:16
 * @TODO 审批客户笔记
 */
class AuditAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);

        $status = $this->RequestData('status',null);
        $remark = $this->RequestData('remark',null);
        $is_open = $this->RequestData('is_open',null);

        if(empty($id)){
            throw new ApiException('请选择客户笔记',1);
        }
        if(empty($status) || !in_array($status,array(3,2))){
            throw new ApiException('请选择状态',1);
        }
        if($status==3 && empty($remark)){
            throw new ApiException('驳回请填写驳回理由',1);
        }

        $model = Note::findOne(['id'=>$id]);
        if(empty($model)){
            throw new ApiException('未找到此客户笔记',1);
        }
        if($model->status!=1){
            throw new ApiException('此笔记已审核',1);
        }
        $model->is_open = $is_open;
        $model->remark = $remark;
        $model->status = $status;

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id']=$model->id;

        return $jsonData;
    }

}