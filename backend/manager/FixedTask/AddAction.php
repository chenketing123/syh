<?php

namespace backend\manager\FixedTask;

use backend\models\TextTask;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\models\FixedTask;
use backend\models\Employee;
use backend\models\FixedTaskLog;


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

        $user_ids = $this->RequestData('user_ids',array());
        $month = $this->RequestData('month','');
        $start_time = $this->RequestData('start_time','');
        $end_time = $this->RequestData('end_time','');
        $statistics_time = $this->RequestData('statistics_time','');
        $task_audit_step = $this->RequestData('task_audit_step',0);
        $task_audit_user = $this->RequestData('task_audit_user',0);
        $data_ids = $this->RequestData('data_ids',array());
        $text_ids = $this->RequestData('text_ids',array());
 

        if(empty($month)){
            throw new ApiException('月份不能为空',1);
        }
        if(empty($start_time)){
            throw new ApiException('开始时间不能为空',1);
        }
        if(empty($end_time)){
            throw new ApiException('结束时间不能为空',1);
        }
        if(empty($statistics_time)){
            throw new ApiException('统计关账时间不能为空',1);
        }
        if(empty($user_ids)){
            throw new ApiException('所属负责人不能为空',1);
        }
        if(empty($data_ids) && empty($text_ids)){
            throw new ApiException('数据型任务和文字型任务不能同时为空',1);
        }

        $user_ids = is_array($user_ids)?$user_ids:explode(',',$user_ids);
        $data_ids = is_array($data_ids)?$data_ids:explode(',',$data_ids);
        $text_ids = is_array($text_ids)?$text_ids:explode(',',$text_ids);

        $model = new FixedTask();
        $model->month = $month;
        $model->start_time = $start_time;
        $model->end_time = $end_time;
        $model->statistics_time = $statistics_time;
        $model->task_audit_user = $task_audit_user;
        $model->task_audit_step = $task_audit_step;
 
        $time = time();

        //获取月份已有任务，重复任务新的覆盖原先的
        $log = FixedTask::find()->where(['month'=>$model->month])->all();
        $logData = array();
        foreach ($log as $v){
            $logData[$v['month'].'_'.$v['user_id'].'_'.$v['type'].'_'.$v['task_type']]=$v['id'];
        }
        //要删除的任务ID
        $delIds = array();

        $status = 2;
        /*if($model->target_time<date('Y-m-d')){
            $status=4;
        }*/

        $addData=array();

        $AuditUserData = array();

        $taskTypeArr = FixedTask::$task_type;
        $textTaskArr = TextTask::getList(1);

        foreach ($user_ids as $v2){

            $user = Employee::findOne(['id'=>$v2]);

            $AuditUserData[$v2] = $user->getAuditUserData($model->task_audit_user,$model->task_audit_step);
            $AuditUser=array(
                'audit_user2'=>0,
                'audit_user2_name'=>0,
                'audit1'=>0,
            );
            if(isset($AuditUserData[$v2][1])) {

                $AuditUser=array(
                    'audit_user2'=>$AuditUserData[$v2][1]['id'],
                    'audit_user2_name'=>$AuditUserData[$v2][1]['name'],
                    'audit1'=> $AuditUserData[$v2][1]['id'],
                );
            }
            if(!empty($data_ids)){
                foreach ($data_ids as $v3){
                    if(isset($taskTypeArr[$v3])){
                        //判断是相同任务，添加删除ID
                        if(isset($logData[$model->month.'_'.$v2.'_1_'.$v3])){
                            $delIds[]=$logData[$model->month.'_'.$v2.'_1_'.$v3];
                        }
                        $addData[$model->month.'_'.$v2.'_1_'.$v3]=array(
                            'user_id' => $v2,
                            'month' => $model->month,
                            'start_time' => $model->start_time,
                            'end_time' => $model->end_time,
                            'target_time' => $model->target_time,
                            'statistics_time' => $model->statistics_time,
                            'type' => 1,
                            'task_type' => $v3,
                            'task_type_title' => $taskTypeArr[$v3],
                            'minimum' => 0,
                            'punish' => 0,
                            'sprint1' => 0,
                            'sprint1_award' => 0,
                            'sprint2' => 0,
                            'sprint2_award' => 0,
                            'sprint3' => 0,
                            'sprint3_award' => 0,
                            'finish_data' => 0,
                            'status' => $status,
                            'dispose_status' => 1,
                            'award' => 0,
                            'append' => $time,
                            'updated' => $time,
                            'audit_step'=>1,
                            'audit_user2'=>$AuditUser['audit_user2'],
                            'audit_user2_name'=>$AuditUser['audit_user2_name'],
                            'audit1'=>$AuditUser['audit1'],
                            'task_audit_user'=>$model->task_audit_user,
                            'task_audit_step'=>$model->task_audit_step,
                        );
                    }
                }
            }
            if(!empty($text_ids)){
                foreach ($text_ids as $v3){
                    if(isset($textTaskArr[$v3])){
                        //判断是相同任务，添加删除ID
                        if(isset($logData[$model->month.'_'.$v2.'_2_'.$v3])){
                            $delIds[]=$logData[$model->month.'_'.$v2.'_2_'.$v3];
                        }
                        $addData[$model->month.'_'.$v2.'_2_'.$v3]=array(
                            'user_id' => $v2,
                            'month' => $model->month,
                            'start_time' => $model->start_time,
                            'end_time' => $model->end_time,
                            'target_time' => $model->target_time,
                            'statistics_time' => $model->statistics_time,
                            'type' => 2,
                            'task_type' => $v3,
                            'task_type_title' => $textTaskArr[$v3],
                            'minimum' => 0,
                            'punish' => 0,
                            'sprint1' => 0,
                            'sprint1_award' => 0,
                            'sprint2' => 0,
                            'sprint2_award' => 0,
                            'sprint3' => 0,
                            'sprint3_award' => 0,
                            'finish_data' => 0,
                            'status' => $status,
                            'dispose_status' => 1,
                            'award' => 0,
                            'append' => $time,
                            'updated' => $time,
                            'audit_step'=>1,
                            'audit_user2'=>$AuditUser['audit_user2'],
                            'audit_user2_name'=>$AuditUser['audit_user2_name'],
                            'audit1'=>$AuditUser['audit1'],
                            'task_audit_user'=>$model->task_audit_user,
                            'task_audit_step'=>$model->task_audit_step,
                        );
                    }
                }
            }
        }
        $num = 0;
        //再执行批量插入
        if (!empty($addData))
        {
            if(!empty($delIds)){
                //删除重复任务
                FixedTask::deleteAll(['in','id',$delIds]);
                //SprintLog::deleteAll(['in','fixed_task_id',$delIds]);
                //FinishDataApply::deleteAll(['in','fixed_task_id',$delIds]);
                FixedTaskLog::deleteAll(['in','fixed_task_id',$delIds]);
            }

            $newId = FixedTask::find()->orderBy('id desc')->limit(1)->one();

            $num = Yii::$app->db->createCommand()
                ->batchInsert(FixedTask::tableName(),['user_id','month','start_time','end_time','target_time','statistics_time','type','task_type','task_type_title','minimum','punish','sprint1','sprint1_award','sprint2','sprint2_award','sprint3','sprint3_award','finish_data','status','dispose_status','award','append','updated','audit_step','audit_user2','audit_user2_name','audit1','task_audit_user','task_audit_step'],
                    $addData)
                ->execute();

            $newId = empty($newId)?0:$newId->id;

            $newModels = FixedTask::find()->andWhere(['>','id',$newId])->all();

            foreach ($newModels as $v){
                $v->SendMsg();
                FixedTaskLog::AddLog($v,0,1);
                FixedTaskLog::AddLog($v,0,2);
            }
        }
        $jsonData=array(
            'num'=>$num,
        );
        return $jsonData;

    }

}