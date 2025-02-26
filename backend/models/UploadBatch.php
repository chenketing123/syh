<?php

namespace backend\models;

use common\components\CommonFunction;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%live_session}}".
 *
 * @property string $id
 * @property string $name
 * @property string $date
 * @property string $files
 * @property integer $status
 * @property string $errmsg
 * @property string $append
 * @property string $updated
 */
class UploadBatch extends \yii\db\ActiveRecord
{
    public static $status = [
        1=>'待处理',
        2=>'处理中',
        3=>'处理完成',
        4=>'处理失败',
    ];
    public static $type = [
        1=>'会员拉黑',
        2=>'会员恢复',
        3=>'客户交接',
        4=>'会员设置员工标签',
        5=>'设置市场归属',
        6=>'架构导入',
        7=>'员工导入',
        8=>'线下已购次数导入',
    ];
    public static $type2 = [
        1=>'会员拉黑',
        2=>'会员恢复',
        3=>'客户交接',
        4=>'会员设置员工标签',
        5=>'设置市场归属',
        8=>'线下已购次数导入',
    ];
    public $errorArr;//错误信息
    public $data; //数据
    /**
     * @inheritdoc
     */
    public static function tableName()
    {

        return '{{%upload_batch}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['files','type'], 'required'],
            [['errmsg'], 'safe'],
            [['type','status', 'append', 'updated'], 'integer'],
            [['files'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '操作类型',
            'files' => '上传文件',
            'status' => '状态',
            'errmsg' => '错误信息',
            'append' => '添加时间',
            'updated' => '修改时间',
        ];
    }

    /**
    * @return array
    */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * 自动插入
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord)
        {

        }else{

        }

        if(is_array($this->errmsg)){
            $this->errmsg = serialize($this->errmsg);
        }elseif (empty($this->errmsg)){
            $this->errmsg = serialize(array());
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return bool
     * User:五更的猫
     * DateTime:2022/8/4 16:01
     * TODO 批量拉黑
     */
    public function Operation1(){
        if(!empty($this->data)){
            $roomData = LiveRoom::find()->indexBy('title')->select('id')->column();

            $Ids = array();
            $errorArr = array();
            foreach ($this->data as $v){
                if(!empty($v['A']) && !empty($v['B']) && !empty($v['C'])) {
                    $v['B'] = trim($v['B']);
                    if (!isset($roomData[$v['B']])) {
                        $errorArr[] = '序号为：' . $v['A'] . '条数据错误，没有此直播间，请检查直播间名称！';
                        continue;
                    }
                    $Ids[$roomData[$v['B']]][]=(int)$v['C'];
                }
            }
            foreach ($Ids as $k=>$v){
                UserRoom::updateAll(['is_show_live'=>2],['and',['room_id'=>$k],['in','user_id',$v]]);
            }
            $this->status = 3;
            $this->errmsg = serialize($errorArr);
            return $this->save();
        }
        return true;
    }
    /**
     * @return bool
     * User:五更的猫
     * DateTime:2022/8/4 16:01
     * TODO 批量恢复
     */
    public function Operation2(){
        if(!empty($this->data)){
            $roomData = LiveRoom::find()->indexBy('title')->select('id')->column();

            $Ids = array();
            $errorArr = array();
            foreach ($this->data as $v){
                if(!empty($v['A']) && !empty($v['B']) && !empty($v['C'])) {
                    $v['B'] = trim($v['B']);
                    if (!isset($roomData[$v['B']])) {
                        $errorArr[] = '序号为：' . $v['A'] . '条数据错误，没有此直播间，请检查直播间名称！';
                        continue;
                    }
                    $Ids[$roomData[$v['B']]][]=(int)$v['C'];
                }
            }
            foreach ($Ids as $k=>$v){
                UserRoom::updateAll(['is_show_live'=>1],['and',['room_id'=>$k],['in','user_id',$v]]);
            }
            $this->status = 3;
            $this->errmsg = serialize($errorArr);
            return $this->save();
        }
        return true;
    }

    /**
     * @return bool
     * User:五更的猫
     * DateTime:2022/8/4 16:53
     * TODO 批量更改员工
     */
    public function Operation3(){
        if(!empty($this->data)){
            $roomData = LiveRoom::find()->indexBy('title')->select('id')->column();

            $Ids = array();
            $errorArr = array();
            $Employee = array();
            foreach ($this->data as $v){
                if(!empty($v['A']) && !empty($v['B']) && !empty($v['C']) && !empty($v['D'])) {

                    $v['B'] = trim($v['B']);
                    if (!isset($roomData[$v['B']])) {
                        $errorArr[] = '序号为：' . $v['A'] . '条数据错误，没有此直播间，请检查直播间名称！';
                        continue;
                    }
                    $v['D'] = (int)$v['D'];
                    if(!isset($Employee[$v['D']])){
                        $Employee[$v['D']] = Employee::findOne(['id'=>$v['D']]);
                    }
                    if(empty($Employee[$v['D']])){
                        $errorArr[] = '序号为：' . $v['A'] . '条数据错误，没有此员工，请检查邀请码！';
                        continue;
                    }
                    $Ids[$roomData[$v['B']]][$v['D']][(int)$v['C']]=(int)$v['C'];
                }
            }
            foreach ($Ids as $k=>$v){
                foreach ($v as $k2=>$v2){
                    $employee_arr = empty($Employee[$k2]['pid_arr'])?$Employee[$k2]['id']:$Employee[$k2]['pid_arr'].','.$Employee[$k2]['id'];

                    //获取营业员，营业员单独处理
                    $models = UserRoom::find()->alias('ur')
                        ->join('INNER JOIN',User::tableName()." AS u","ur.user_id = u.id and ur.room_id=".$k)
                        ->andWhere(['u.is_assistant'=>1])
                        ->all();

                    //上传的数据中去除营业员
                    foreach ($models as $v3){
                        if(isset($v2[$v3['user_id']])){
                            unset($v2[$v3['user_id']]);
                        }
                    }
                    if(!empty($v2)) {
                        UserRoom::updateAll(['employee_id' => $Employee[$k2]['id'], 'employee_arr' => $employee_arr, 'department_arr' => $Employee[$k2]['department_arr'],'department_id' => $Employee[$k2]['main_department']], ['and', ['room_id' => $k], ['in', 'user_id', $v2]]);
                    }
                    foreach ($models as $v3){
                        $v3->employee_id = $Employee[$k2]['id'];
                        $v3->employee_arr = $employee_arr;
                        $v3->department_arr = $Employee[$k2]['department_arr'];
                        $v3->department_id = $Employee[$k2]['main_department'];
                        $v3->save();
                    }
                }
            }
            $this->status = 3;
            $this->errmsg = serialize($errorArr);
            return $this->save();
        }
        return true;
    }

    /**
     * @return bool
     * User:五更的猫
     * DateTime:2022/8/4 16:01
     * TODO 批量设置员工标签
     */
    public function Operation4(){
        if(!empty($this->data)){

            $Ids = array();
            $NotIds = array();
            $errorArr = array();
            $type = array(
                '是'=>1,
                '否'=>2
            );
            foreach ($this->data as $v){
                if(!empty($v['A']) && !empty($v['B']) && !empty($v['C'])) {
                    if(isset($type[(string)$v['C']])){
                        if($type[(string)$v['C']]==1){
                            $Ids[] = (int)$v['B'];
                        }else{
                            $NotIds[] = (int)$v['B'];
                        }
                    }else{
                        $errorArr[] = '序号为：' . $v['A'] . '条数据错误，请检查是否员工字段是否正确！';
                        continue;
                    }
                }
            }
            if(!empty($Ids)){
                User::updateAll(['is_employee'=>1],['in','id',$Ids]);
            }
            if(!empty($NotIds)){
                User::updateAll(['is_employee'=>2],['in','id',$NotIds]);
            }
            $this->status = 3;
            $this->errmsg = serialize($errorArr);
            return $this->save();
        }
        return true;
    }

    /**
     * @return bool
     * User:五更的猫
     * DateTime:2022/8/4 16:01
     * TODO 批量设置市场归属
     */
    public function Operation5(){
        if(!empty($this->data)){

            $errorArr = array();
            $MarketArr = Market::getIdList();

            $datas = array();

            foreach ($this->data as $v){
                if(!empty($v['A']) && !empty($v['B']) && !empty($v['C'])) {
                    if(isset($MarketArr[(string)$v['C']])){
                        $datas[$MarketArr[(string)$v['C']]][]=(int)$v['B'];
                    }else{
                        $errorArr[] = '序号为：' . $v['A'] . '条数据错误，未找到此市场归属！';
                        continue;
                    }
                }
            }
            foreach ($datas as $k=>$v){
                Employee::updateAll(['market'=>$k],['in','id',$v]);
            }

            $this->status = 3;
            $this->errmsg = serialize($errorArr);
            return $this->save();
        }
        return true;
    }

    /**
     * @return bool
     * User:五更的猫
     * DateTime:2022/10/18 14:53
     * TODO 导入组织架构
     */
    public function Operation6(){
        if(!empty($this->data)){

            $errorArr = array();

            $DepartmentData = Department::find()->indexBy('name')->select('id,name,parentid')->asArray()->all();

            $model = new Department();
            $notDel = array();
            $datas=array();

            foreach ($this->data as $v){
                if(!empty($v['A']) && !empty($v['C'])) {
                    $pid = 0;

                    if(!empty($v['B'])){
                        $pidArr = explode('-',$v['B']);

                        foreach ($pidArr as $v2){
                            $v2 = trim($v2);
                            if(isset($DepartmentData[$v2])){
                                if($DepartmentData[$v2]['parentid']!=$pid){
                                    $DepartmentModel = Department::findOne($DepartmentData[$v2]['id']);
                                    if(!empty($DepartmentModel)){
                                        $DepartmentModel->parentid = $pid;
                                        if(!$DepartmentModel->save()){
                                            $errorArr[] = '序号为：' . $v['A'] . '条数据错误，更改上级关系错误！';
                                            continue;
                                        }
                                        $DepartmentData[$v2]['parentid'] = $pid;
                                    }
                                }
                                $pid = $DepartmentData[$v2]['id'];
                                $notDel[$pid]=$pid;
                            }else{
                                $newId = Department::AddTitle($v2,$pid);
                                if($newId===false){
                                    $errorArr[] = '序号为：' . $v['A'] . '条数据错误，添加上级错误！';
                                    continue;
                                }

                                $pid = $newId->id;
                                $DepartmentData[$v2] = array(
                                    'id'=>$newId->id,
                                    'name' => $newId->name,
                                    'parentid' => $newId->parentid,
                                );
                                $notDel[$pid]=$pid;
                            }
                        }
                    }
                    $v['C'] = trim((string)$v['C']);

                    if(isset($DepartmentData[$v['C']])){
                        $DepartmentModel = Department::findOne($DepartmentData[$v['C']]['id']);
                        if(!empty($DepartmentModel)){
                            $DepartmentModel->parentid = $pid;
                            if(!$DepartmentModel->save()){
                                $errorArr[] = '序号为：' . $v['A'] . '条数据错误，更改关系错误！';
                                continue;
                            }
                            $DepartmentData[$v['C']]['parentid'] = $pid;

                            $notDel[$DepartmentData[$v['C']]['id']]=$DepartmentData[$v['C']]['id'];
                        }
                    }else {
                        $data = array(
                            'name' => $v['C'],
                            'parentid' => $pid,
                        );

                        $model->isNewRecord = true;
                        $model->setAttributes($data);
                        if ($model->save()) {
                            $DepartmentData[$model->name] = array(
                                'id' => $model->id,
                                'name' => $model->name,
                                'parentid' => $model->parentid,
                            );
                            $notDel[$model->id]=$model->id;
                            $model->id = 0;
                        } else {
                            $errorArr[] = '序号为：' . $v['A'] . '条数据错误：' . CommonFunction::getStrError($model->getErrors());
                            continue;
                        }
                    }
                }
            }

            Department::deleteAll(['not in','id',$notDel]);

            //if(!empty($notDel)) {
                Employee::updateAll(['main_department' => 0, 'pid_arr' => 0, 'department_arr' => '','department'=>0], ['not in', 'main_department', $notDel]);
            //}

            $this->UpdatePidArr();

            sleep(60);

            $this->UpdateUserMap();

            $this->status = 3;
            $this->errmsg = serialize($errorArr);
            return $this->save();
        }
        return true;
    }

    /**
     * @return bool
     * User:五更的猫
     * DateTime:2022/10/18 14:53
     * TODO 导入员工
     */
    public function Operation7(){
        if(!empty($this->data)){

            $errorArr = array();

            $DepartmentData = Department::find()->indexBy('name')->select('id')->asArray()->column();

            $EmployeeData = Employee::find()->indexBy('userid')->select('id')->asArray()->column();

            $marketData = Market::find()->indexBy('title')->select('id')->asArray()->column();


            $sexArr = array_flip(Params::$sex2);

            $statusArr = array_flip(Employee::$status);

            $isArr = array_flip(Params::$is);

            $model = new Employee();

            foreach ($this->data as $v){
                if(!empty($v['A'])  && !empty($v['B'])  && !empty($v['C'])  && !empty($v['F'])) {
                    if(!isset($DepartmentData[(string)$v['F']])){
                        $errorArr[] = '序号为：' . $v['A'] . '条数据错误，未找到此部门！';
                        continue;
                    }

                    if(isset($EmployeeData[$v['C']])){
                        $model = Employee::findOne($EmployeeData[$v['C']]);

                    }else{
                        $model->auth_key = Yii::$app->security->generateRandomString();
                        $model->isNewRecord = true;
                        $model->id = 0;
                    }
                    $model->userid = trim((string)$v['C']);

                    if(!isset($marketData[$v['K']])){
                        $marketModel = new Market();
                        $marketModel->title = (string)$v['K'];
                        if(!$marketModel->save()){
                            $errorArr[] = '序号为：' . $v['A'] . '条数据错误，新增市场错误！';
                            continue;
                        }
                        $marketData[$v['K']] = $marketModel->id;
                    }
                    $model->market = $marketData[(string)$v['K']];
                    $model->name = (string)$v['B'];
                    $model->mobile = (string)$v['H'];
                    $model->position = (string)$v['E'];
                    $model->gender = $sexArr[(string)$v['G']];
                    $model->email = (string)$v['I'];
                    $model->alias = (string)$v['D'];
                    $model->status = $statusArr[(string)$v['J']];
                    $model->main_department = $DepartmentData[(string)$v['F']];
                    $model->is_leader = $isArr[(string)$v['L']];

                    if ($model->save()) {

                        $EmployeeData[$model->userid] = $model->id;

                    } else {
                        $errorArr[] = '序号为：' . $v['A'] . '条数据错误：' . CommonFunction::getStrError($model->getErrors());
                    }

                }
            }

            $this->UpdatePidArr();

            sleep(60);

            $this->UpdateUserMap();

            $this->status = 3;
            $this->errmsg = serialize($errorArr);
            return $this->save();
        }
        return true;
    }

    public function UpdatePidArr($parentid=0,$pid_arr='',$department_arr=''){

        $models = Department::find()->where(['parentid'=>$parentid])->orderBy('sort Asc,id desc')->all();

        foreach ($models as $v){
            $pid_arr2 = $pid_arr;
            $v->pid_arr = $department_arr;
            $v->save();
            $departmentArr =  empty($department_arr)?(string)$v['id']:$department_arr.','.$v['id'];

            $user = Employee::find()->where(['main_department'=>$v['id']])->orderBy('is_leader asc')->all();
            $arr='';
            foreach ($user as $v2){

                if($v2['is_leader']==1){
                    $v2->department_arr = (string)$departmentArr;
                    $v2->pid_arr = (string)$pid_arr2;
                    $v2->save();
                    $arr.=empty($arr)?$v2['id']:','.$v2['id'];
                }else{

                    $v2->department_arr = (string)$departmentArr;
                    if(!empty($pid_arr2)){
                        $v2->pid_arr = empty($arr)?(string)$pid_arr2:$pid_arr2.','.$arr;
                    }else{
                        $v2->pid_arr = (string)$arr;
                    }
                    $v2->save();
                }
                //批量更新用户架构上级
            }
            if(!empty($pid_arr2) && !empty($arr)){
                $pid_arr2 = $pid_arr2.','.$arr;
            }elseif (!empty($arr)){
                $pid_arr2 = $arr;
            }
            $this->UpdatePidArr($v['id'],$pid_arr2,$departmentArr);
        }

        return true;
    }
    public function UpdateUserMap(){
        echo date('Y-m-d H:i:s')."-UpdateUserMap Start-\r\n";

        $models = Employee::find()->orderBy('is_leader asc')->all();

        foreach ($models as $v){
            $employee_arr = empty($v['pid_arr'])?$v['id']:$v['pid_arr'].','.$v['id'];
            $department_arr = $v['department_arr'];

            UserRoom::updateAll(['employee_arr'=>$employee_arr,'department_arr'=>$department_arr,'department_id'=>$v['main_department']],['employee_id'=>$v['id']]);
        }
        return true;
    }

    /**
     * @return bool
     * User:五更的猫
     * DateTime:2022/8/4 16:01
     * TODO 批量恢复
     */
    public function Operation8(){
        if(!empty($this->data)){
            $roomData = LiveRoom::find()->indexBy('title')->select('id')->column();

            $Ids = array();
            $errorArr = array();
            foreach ($this->data as $v){
                if(!empty($v['A']) && !empty($v['B']) && !empty($v['C'])  && !empty($v['D'])) {
                    $v['B'] = trim($v['B']);
                    if (!isset($roomData[$v['B']])) {
                        $errorArr[] = '序号为：' . $v['A'] . '条数据错误，没有此直播间，请检查直播间名称！';
                        continue;
                    }
                    $v['D'] = (int)$v['D'];
                    $Ids[$roomData[$v['B']]][$v['D']][]=(int)$v['C'];

                }
            }
            foreach ($Ids as $k=>$v){
                foreach ($v as $k2=>$v2) {
                    UserRoom::updateAll(['init_buy_count' => $k2], ['and', ['room_id' => $k], ['in', 'user_id', $v2]]);
                    foreach ($v2 as $v3){
                        UserRoom::SetBuyCount($v3,$k);
                    }
                }
            }
            $this->status = 3;
            $this->errmsg = serialize($errorArr);
            return $this->save();
        }
        return true;
    }
}
