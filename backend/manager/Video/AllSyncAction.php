<?php

namespace backend\manager\Video;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\Video;
use backend\models\LiveSession;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class AllSyncAction extends ManagerApiAction
{
    protected function runAction()
    {

        $models = LiveSession::find()->andWhere(['is_playback'=>1])->all();

        $videoModels = Video::find()->andWhere(['not',['session_id'=>0]])->all();

        $list = array();
        foreach ($videoModels as $v){
            $list[$v['session_id']] = $v;
        }
        $data = array();

        foreach ($models as $v){
            if(isset($list[$v['id']])){
                $list[$v['id']]->room_id = $v['room_id'];
                $list[$v['id']]->name = $v['name'];
                $list[$v['id']]->url = $v['url'];
                $list[$v['id']]->cover = $v['cover'];
                $list[$v['id']]->yz_id = $v['yz_id'];

                $list[$v['id']]->year = $v['year'];
                $list[$v['id']]->month = $v['month'];
                $list[$v['id']]->day = 1;
                $list[$v['id']]->province = $v['province'];
                $list[$v['id']]->city = $v['city'];
                $list[$v['id']]->district = $v['district'];
                $list[$v['id']]->street = $v['street'];
                $list[$v['id']]->user = $v['customer_name'];
                $list[$v['id']]->remark = $v['keyword'];
                $list[$v['id']]->entity = $v['entity1'];


                $list[$v['id']]->save();
            }else{
                $model = new Video();
                $model->room_id = $v['room_id'];
                $model->name = $v['name'];
                $model->url = $v['url'];
                $model->cover = $v['cover'];
                $model->yz_id = $v['yz_id'];
                $model->session_id = $v['id'];

                $model->year = $v['year'];
                $model->month = $v['month'];
                $model->day = 1;
                $model->province = $v['province'];
                $model->city = $v['city'];
                $model->district = $v['district'];
                $model->street = $v['street'];
                $model->user = $v['customer_name'];
                $model->remark = $v['keyword'];
                $model->entity = $v['entity1'];

                $model->save();
            }
        }
        
 

 

 
 
 
    }


 
 



}