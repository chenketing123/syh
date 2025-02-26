<?php
namespace console\controllers;

use backend\models\AwardLog;
use backend\models\Download;
use backend\models\EmployeeRoom;
use backend\models\LiveActivity;
use backend\models\LiveActivityData;
use backend\models\LiveData;
use backend\models\LiveRoom;
use backend\models\LiveSession;
use backend\models\Params;
use backend\models\UploadBatch;
use backend\models\UserRoom;
use backend\models\ViewLog;
use backend\models\WithdrawError;
use backend\models\WithdrawLog;
use common\components\CommonFunction;
use common\components\Pay;
use Yii;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\Url;

/**
 * Site controller
 */
class IndexController extends Controller
{

    /**
     * User:五更的猫
     * DateTime:2021/10/22 16:41
     * TODO 更新直播数据
     */
    public function actionUpdateLiveData(){

        echo date('Y-m-d H:i:s')."-Start111-\r\n";
        ini_set ("memory_limit","-1");

        $models = LiveSession::find()->where(['or',['>=','end_stat_date',date('Y-m-d',strtotime('-1 day'))],['>=','staff_end_stat_date',date('Y-m-d',strtotime('-1 day'))]])->all();

        $c = count($models);
        $roomData = array();
        $activityArr = array();
        foreach ($models as $v){
            if(!isset($roomData[$v['room_id']])){
                $roomData[$v['room_id']] = LiveRoom::findOne($v['room_id']);
            }
            if(isset($roomData[$v['room_id']])) {
                $activityArr[$v['activity_id']] = $v['activity_id'];
                $this->UpdateLiveData($v['id'], $v['room_id'], $v['activity_id'],$roomData[$v['room_id']]['live_time']);
            }
        }
        sleep(10);
        //有对应的活动更新则更新对应活动的数据
        if(!empty($activityArr)){
            $this->UpdateLiveActivityData($activityArr);
        }

        echo date('Y-m-d H:i:s')."-END-\r\n";
    }
    /**
     * User:五更的猫
     * DateTime:2021/10/22 16:41
     * TODO 更新直播数据
     */
    public function UpdateLiveData($session_id,$room_id,$activity_id,$live_time){

        $models = ViewLog::find()->where(['video_id'=>$session_id])->all();

        if(!empty($models)){

            $InsertData=array();
            $n=0;
            $i=0;
            $sex = Params::$sex2;
            $time = time();
            foreach ($models as $v){
                $n++;
                $InsertData[$i][]=array(
                    'room_id'=>$room_id,
                    'activity_id' => $activity_id,
                    'session_id' => $session_id,
                    'user_id' => $v['user_id'],
                    'nickname' => $v['nickname'],
                    'sex' => $sex[$v['sex']],
                    'ip' => $v['ip'],
                    'one_date' => date('Y-m-d H:i:s',$v['one_date']),
                    'new_date' => date('Y-m-d H:i:s',$v['new_date']),
                    'live_time' => $v['live_time'],
                    'play_time' => $v['play_time'],
                    'live_times' => CommonFunction::GetTime($v['live_time']),
                    'play_times' => CommonFunction::GetTime($v['play_time']),
                    'openid' => $v['openid'],
                    'unionid' => $v['unionid'],
                    'is_full' => $v['live_time']>=$live_time||$v['play_time']>=$live_time?1:2,
                    'price_number' => $v['price_number'],
                    'price_log' => $v['price_log'],
                    'append'=>$v['append'],
                    'updated'=>$v['updated'],
                );

                if($n>10000){
                    $n=0;
                    $i++;
                }
            }
            unset ($models);
            $InsertDataNum=0;
            if (!empty($InsertData))
            {
                //删除原直播数据
                LiveData::deleteAll(['session_id'=>$session_id]);

                foreach ($InsertData as $v) {
                    $InsertDataNum += Yii::$app->db->createCommand()
                        ->batchInsert(LiveData::tableName(), ['room_id','activity_id', 'session_id', 'user_id','nickname', 'sex', 'ip',
                            'one_date','new_date','live_time','play_time','live_times','play_times','openid','unionid','is_full','price_number','price_log','append','updated'],
                            $v)
                        ->execute();

                }
            }
            unset ($InsertData);

        }
        return true;
    }

    /**
     * @param $activityArr
     * User:五更的猫
     * DateTime:2022/7/14 17:13
     * TODO 更新直播活动数据
     */
    public function UpdateLiveActivityData($activityArr){

        echo date('Y-m-d H:i:s')."- UpdateLiveActivityData Start-\r\n";

        $models = LiveActivity::find()->where(['in','id',$activityArr])->where(['>=','award_send_date',date('Y-m-d')])->all();


        $roomData = array();
        foreach ($models as $v){
            if(!isset($roomData[$v['room_id']])){
                $roomData[$v['room_id']] = LiveRoom::findOne($v['room_id']);
            }
            if(isset($roomData[$v['room_id']])) {
                //根据完整观看状态 去求和计算有几次完整观看
                $data = LiveData::find()->where(['activity_id' => $v['id']])->select('room_id,activity_id,user_id,sum(2-is_full) as full_count')->groupBy('user_id')->asArray()->all();

                $InsertData = array();
                $n = 0;
                $i = 0;
                $time = time();
                foreach ($data as $v2) {
                    $n++;
                    $InsertData[$i][] = array(
                        'room_id' => $v2['room_id'],
                        'activity_id' => $v2['activity_id'],
                        'user_id' => $v2['user_id'],
                        'is_full' => $v2['full_count'] >=$roomData[$v['room_id']]['full_count']?1:2,
                        'full_number' => $v2['full_count'],
                        'append'=>$time,
                        'updated'=>$time,
                    );

                    if ($n > 10000) {
                        $n = 0;
                        $i++;
                    }
                }

                $InsertDataNum = 0;
                if (!empty($InsertData)) {
                    //删除原直播数据
                    LiveActivityData::deleteAll(['activity_id' => $v2['activity_id']]);

                    foreach ($InsertData as $v) {
                        $InsertDataNum += Yii::$app->db->createCommand()
                            ->batchInsert(LiveActivityData::tableName(), ['room_id', 'activity_id', 'user_id', 'is_full','full_number', 'append', 'updated'],
                                $v)
                            ->execute();

                    }
                }
            }
        }

        echo date('Y-m-d H:i:s')."- UpdateLiveActivityData END-\r\n";
    }

    /**
     * User:五更的猫
     * DateTime:2021/11/2 14:35
     * TODO 更新视频链接
     */
    public function actionUpdateVideoUrl(){

        echo date('Y-m-d H:i:s')."-Start-\r\n";

        $models = LiveSession::find()->where(['<>','yz_id',''])->all();

        $error=0;
        foreach ($models as $v){
            if(!$v->UpdateVideoUrl()){
                $error++;
            }
        }

        echo date('Y-m-d H:i:s')."-END- ErrorCount:{$error}\r\n";

    }

    /**
     * User:五更的猫
     * DateTime:2021/7/8 10:04
     * TODO 奖励发放
     */
    public function actionSendAward(){

        echo date('Y-m-d H:i:s')."-Start-\r\n";


        $room = LiveRoom::find()->indexBy('id')->asArray()->all();
        //获取活动
        $models = LiveActivity::find()->where(['>=','award_send_date',date('Y-m-d')])->orderBy('sort asc,id desc')->all();

        $SendData = array();

        //活动奖励人   去除已发奖励
        foreach ($models as $v){
            if(isset($room[$v['room_id']])) {
                $this->SendAward($v, $room[$v['room_id']],$SendData);
            }
        }

        echo date('Y-m-d H:i:s')."-END-\r\n";

    }

    /**
     * User:五更的猫
     * DateTime:2021/10/22 16:41
     * TODO 奖励发放
     */
    public function SendAward($Activity,$Room,&$SendData){

        //完整观看人员
        $data = LiveActivityData::find()->alias('lad')->join('INNER JOIN',UserRoom::tableName()." AS ur","ur.user_id = lad.user_id and ur.room_id=".$Room['id'])
            ->where(['lad.activity_id'=>$Activity['id'],'lad.is_full'=>1])
            ->select('lad.*,ur.employee_id')
            ->asArray()
            ->all();

        //已发人员
        $sendIds = AwardLog::find()->where(['activity_id'=>$Activity['id'],'send_type'=>1])->select('user_id')->column();

        $InsertData=array();
        $time = time();

        $SendData[$Room['id']][0]=$Room['is_send_award'];

        foreach ($data as $v){
            //去除已奖励人
            if(!in_array($v['user_id'],$sendIds)){

                //判断是否
                if(!isset($SendData[$Room['id']][$v['employee_id']])){
                    $employee = EmployeeRoom::findOne(['room_id'=>$Room['id'],'employee_id'=>$v['employee_id']]);
                    if(!empty($employee)){
                        $SendData[$Room['id']][$v['employee_id']] = $employee['is_send_award'];
                    }else{
                        $SendData[$Room['id']][$v['employee_id']] = 2;
                    }
                }
                if($SendData[$Room['id']][$v['employee_id']]==1) {
                    $InsertData[] = array(
                        'list_type' => 1,
                        'user_id' => $v['user_id'],
                        'activity_id' => $Activity['id'],
                        'activity_title' => $Activity['name'],
                        'room_id' => $Room['id'],
                        'send_type' => 1,
                        'type' => 1,
                        'end_date' => $Activity['award_close_date'],
                        'append' => $time,
                        'updated' => $time,
                    );
                }
            }
        }

        $InsertDataNum=0;
        if (!empty($InsertData))
        {
            $InsertDataNum += Yii::$app->db->createCommand()
                ->batchInsert(AwardLog::tableName(), ['list_type','user_id', 'activity_id','activity_title', 'room_id', 'send_type', 'type', 'end_date','append','updated'],
                    $InsertData)
                ->execute();

        }

        return true;
    }

    /**
     * User:五更的猫
     * DateTime:2021/11/18 14:54
     * TODO 奖励超时处理
     */
    public function actionAwardOvertime(){

        echo date('Y-m-d H:i:s')."-Start-\r\n";

        $count = AwardLog::updateAll(['status'=>4],['and',['status'=>1],['<','end_date',date('Y-m-d')]]);

        echo date('Y-m-d H:i:s')."-END-  Count:{$count}\r\n";

    }

    /**
     * User:五更的猫
     * DateTime:2020/7/28 10:43
     * TODO 文件导出
     */
    public function actionDownload(){
        $model = Download::find()->where(['status'=>1])->orderBy('id asc')->one();

        $date = date('Y-m-d H:i:s');
        if(!empty($model)){
            $model->status = 2;
            if($model->save()){

                switch ($model->type){
                    case 1:
                        $model->files = $model->type1PutCsv();
                        $model->status = 3;
                        break;
                    case 2:
                        $model->files = $model->type2PutCsv();
                        $model->status = 3;
                        break;
                    case 3:
                        $model->files = $model->type3PutCsv();
                        $model->status = 3;
                        break;
                    case 4:
                        $model->files = $model->type4PutCsv();
                        $model->status = 3;
                        break;
                    case 5:
                        $model->files = $model->type5PutCsv();
                        $model->status = 3;
                        break;
                    case 6:
                        $model->files = $model->type6PutCsv();
                        $model->status = 3;
                        break;
                    case 7:
                        $model->files = $model->type7PutCsv();
                        $model->status = 3;
                        break;
                    case 8:
                        $model->files = $model->type8PutCsv();
                        $model->status = 3;
                        break;
                    case 9:
                        $model->files = $model->type9PutCsv();
                        $model->status = 3;
                        break;
                    case 10:
                        $model->files = $model->type10PutCsv();
                        $model->status = 3;
                        break;
                    case 11:
                        $model->files = $model->type11PutCsv();
                        $model->status = 3;
                        break;
                    case 12:
                        $model->files = $model->type12PutCsv();
                        $model->status = 3;
                        break;
                    case 13:
                        $model->files = $model->type13PutCsv();
                        $model->status = 3;
                        break;
                    case 14:
                        $model->files = $model->type14PutCsv();
                        $model->status = 3;
                        break;
                    case 15:
                        $model->files = $model->type15PutCsv();
                        $model->status = 3;
                        break;
                    case 16:
                        $model->files = $model->type16PutCsv();
                        $model->status = 3;
                        break;
                    case 17:
                        $model->files = $model->type17PutCsv();
                        $model->status = 3;
                        break;
                    case 18:
                        $model->files = $model->type18PutCsv();
                        $model->status = 3;
                        break;
                    case 19:
                        $model->files = $model->type19PutCsv();
                        $model->status = 3;
                        break;
                    case 20:
                        $model->files = $model->type20PutCsv();
                        $model->status = 3;
                        break;
                    case 21:
                        $model->files = $model->type21PutCsv();
                        $model->status = 3;
                        break;
                    case 22:
                        $model->files = $model->type22PutCsv();
                        $model->status = 3;
                        break;
                    case 23:
                        $model->files = $model->type23PutCsv();
                        $model->status = 3;
                        break;
                    case 24:
                        $model->files = $model->type24PutCsv();
                        $model->status = 3;
                        break;
                    default:
                        $model->status = 4;
                        break;
                }

                $model->save();

            }
        }

        echo $date.'~'.date('Y-m-d H:i:s')."Success\r\n";
    }

    /**
     * User:五更的猫
     * DateTime:2022/8/4 16:55
     * TODO 批量操作导入处理
     */
    public function actionUploadBatch(){

        $model = UploadBatch::find()->where(['status'=>1])->orderBy('id asc')->one();

        if(!empty($model)){

            echo date('Y-m-d H:i:s')."-Start-\r\n";

            $model->status = 2;
            if($model->save()){
                $error = CommonFunction::parseExcl($model->files);

                if($error['errcode'] == 0){

                    $model->data = $error['data'];

                    switch ($model->type){
                        case 1:
                            $model->Operation1();
                            break;
                        case 2:
                            $model->Operation2();
                            break;
                        case 3:
                            $model->Operation3();
                            break;
                        case 4:
                            $model->Operation4();
                            break;
                        case 5:
                            $model->Operation5();
                            break;
                        case 6:
                            $model->Operation6();
                            break;
                        case 7:
                            $model->Operation7();
                            break;
                        case 8:
                            $model->Operation8();
                            break;
                        default:
                            $errmsg = array('未知操作');
                            $model->status = 4;
                            $model->errmsg = serialize($errmsg);
                            $model->save();
                            break;
                    }
                }else{
                    $errmsg = array($error['errmsg']);
                    $model->status = 4;
                    $model->errmsg = serialize($errmsg);
                    $model->save();
                }

            }
        }

        echo date('Y-m-d H:i:s')." Success\r\n";
    }

    /**
     * User:五更的猫
     * DateTime:2022/10/13 10:36
     * TODO 红包提现
     */
    public function actionWithdraw(){
        echo date('Y-m-d H:i:s')."-Start-\r\n";

        $models = UserRoom::find()->andWhere(['>=','price',0.3])->all();

        $count = count($models);

        $roomData = LiveRoom::find()->indexBy('id')->select('title')->asArray()->column();

        foreach ($models as $v){

            if($v->IsWithdraw() && isset($v->user)){

                $order_no = 'TX'.$v['room_id'].$v['user_id'].date('YmdHis').rand(100000,999999);
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model = new WithdrawLog();
                    $model->room_id = $v['room_id'];
                    $model->user_id = $v['user_id'];
                    $model->order_no = $order_no;
                    $model->price = $v['price'];
                    $model->openid = $v->user['openid'];
                    $model->status = 1;

                    if(!$model->save()){
                        $error = $model->getErrors();
                        $error = reset($error);
                        throw new Exception(reset($error));
                    }

                    if (!$v->user->AddPrice($v['room_id'], $v['price'], '红包提现', 2)) {
                        throw new Exception('红包提现失败');
                    }
                    if(!isset($roomData[$v['room_id']])){
                        $roomData[$v['room_id']] = '未知直播间';
                    }

                    $payData = Pay::Withdraw($model->id,'直播间：'.$roomData[$v['room_id']].' 红包提现');

                    if($payData['errcode']!=0 && $payData['errcode']!=2){

                        throw new Exception($payData['errmsg']);
                    }
                    if($payData['errcode']==2){
                        $model->status = 2;
                        $model->errmsg = $payData['errmsg'];
                        $model->save();
                    }

                    $transaction->commit();

                } catch (Exception $e) {

                    $transaction->rollBack();

                    $model = new WithdrawError();
                    $model->room_id = $v['room_id'];
                    $model->user_id = $v['user_id'];
                    $model->order_no = $order_no;
                    $model->price = $v['price'];
                    $model->openid = $v->user['openid'];
                    $model->errmsg = $e->getMessage();
                    $model->save();

                }

            }
        }

        echo date('Y-m-d H:i:s')."-END-  Count:{$count}\r\n";
    }

    /**
     * User:五更的猫
     * DateTime:2022/11/8 17:14
     * TODO 更新用户直播间全部完整观看次数
     */
    public function actionUpdateFullNumber(){

        echo date('Y-m-d H:i:s')."-Start-\r\n";

        $models = LiveActivityData::find()->groupBy('room_id,user_id')->select('room_id,user_id,sum(full_number) as full_number')->asArray()->all();

        $data = array();
        foreach ($models as $v){
            $data[$v['room_id']][$v['full_number']][]=$v['user_id'];
        }

        $Num=0;
        //默认播放0
        UserRoom::updateAll(['full_number'=>0]);
        //循环更改播放次数
        foreach ($data as $k=>$v){
            foreach ($v as $k2=>$v2){
                if (!empty($v2))
                {
                    $Num = UserRoom::updateAll(['full_number'=>$k2],['and',['room_id'=>$k],['in','user_id',$v2]]);
                }
            }
        }

        echo date('Y-m-d H:i:s')."-END- Num:{$Num}\r\n";
    }


}
