<?php

namespace backend\manager\questionBank;

use backend\models\QuestionBank;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class SaveAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 17:15
 * @TODO 题库保存
 */
class SaveAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);
        $title = $this->RequestData('title',null);
        $type = $this->RequestData('type',null);
        $data = $this->RequestData('data',array());
        
        /*array(
            array(
                'title'=>'题目',
                'is_checked'=>1,//是否选中 1：是 0:否
            )
        );*/

        $status = $this->RequestData('status',1);
        $sort = $this->RequestData('sort',100);


        if(empty($title)){
            throw new ApiException('请填写题目',1);
        }
        if(empty($type) || !in_array($type,array(1,2))){
            throw new ApiException('题目类型错误',1);
        }
        if(empty($status) || !in_array($status,array(1,2))){
            throw new ApiException('状态错误',1);
        }
        if(empty($sort)){
            throw new ApiException('请填写排序',1);
        }
        if(empty($data)){
            throw new ApiException('请填写问题选项',1);
        }
        $data = is_array($data)?$data:json_decode($data,true);

        $content = array();
        $answer = array();
        $i=1;
        foreach ($data as $v){
            if(isset($v['title']) && isset($v['is_checked'])){
                $content[$i] = $v['title'];
                if($v['is_checked']==1){
                    $answer[] = $v['title'];
                }
                $i++;
            }else{
                throw new ApiException('问题选项数据格式不正确',1);
            }
        }
        if(empty($content)){
            throw new ApiException('请添加题目',1);
        }
        if(empty($answer)){
            throw new ApiException('请添加题目答案',1);
        }
        if($type==1 && count($answer)>1){
            throw new ApiException('单选题不能选择多个答案',1);
        }

        if(!empty($id)){
            $model = QuestionBank::findOne(['id'=>$id]);
            if(empty($model)){
                throw new ApiException('未找到此题目',1);
            }
        }else{
            $model = new QuestionBank();
        }

        $model->title = $title;
        $model->type = $type;
        $model->content = json_encode($content);
        $model->answer = json_encode($answer);
        $model->sort = $sort;
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