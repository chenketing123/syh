<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "yl_manager".
 *
 * @property integer $id
 * @property string $openid
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $password_reset_token
 * @property integer $type
 * @property string $realname
 * @property string $head_portrait
 * @property integer $sex
 * @property string $qq
 * @property string $email
 * @property string $birthday
 * @property integer $user_integral
 * @property string $address
 * @property integer $visit_count
 * @property string $home_phone
 * @property string $mobile_phone
 * @property integer $role
 * @property integer $status
 * @property integer $last_time
 * @property string $last_ip
 * @property integer $created_at
 * @property integer $updated_at
 */
class Manager extends \common\models\User
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manager}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['password_hash','username'], 'required'],
            ['username', 'unique','message'=>'用户账户已经占用'],
            [['type', 'sex', 'user_integral', 'visit_count', 'role', 'role_id','status', 'last_time', 'created_at', 'updated_at','jxc_user_id','is_download','is_archives'], 'integer'],
            [['birthday'], 'safe'],
            [['username', 'qq', 'home_phone', 'mobile_phone'], 'string', 'max' => 15],
            ['mobile_phone','match','pattern'=>'/^[1][3578][0-9]{9}$/','message'=>'不是一个有效的手机号码'],
            [['password_hash', 'password_reset_token', 'head_portrait'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['realname'], 'string', 'max' => 10],
            [['provinces','city','area'], 'string', 'max' => 10],
            [['address'], 'string', 'max' => 100],
            [['email'],'email'],
            [['email'], 'string', 'max' => 60],
            [['last_ip'], 'string', 'max' => 16],
            ['last_ip','default', 'value' => '0.0.0.0'],
            ['jxc_user_id','default', 'value' => '0'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                      => 'ID',
            'username'                => '登录名',
            'password_hash'           => '登录密码',
            'auth_key'                => 'Auth Key',
            'password_reset_token'    => 'Password Reset Token',
            'type'                    => '管理员类型',
            'realname'                => '真实姓名',
            'head_portrait'           => '个人头像',
            'sex'                     => '性别',
            'qq'                      => 'qq',
            'email'                   => '邮箱',
            'birthday'                => '出生日期',
            'user_integral'           => '用户积分',
            'address'                 => '详细地址',
            'provinces'               => '省份',
            'city'                    => '城市',
            'area'                    => '区',
            'visit_count'             => '登陆次数',
            'home_phone'              => '家庭电话',
            'mobile_phone'            => '手机号码',
            'role'                    => 'Role',
            'status'                  => '状态',
            'last_time'               => '最后登录的时间',
            'last_ip'                 => '最后登录的IP地址',
            'created_at'              => '创建时间',
            'updated_at'              => '修改时间',
            'jxc_user_id'             => '绑定进销存管理账号',
            'is_download'             => '是否导出',
            'is_archives'             => '是否修改档案',
            'role_id'                 => '角色',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignment()
    {
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManagerRole()
    {
        return $this->hasOne(ManagerRole::className(), ['id' => 'role_id']);
    }
    /**
     * 更新登陆信息
     */
    static public function upLoginInfo()
    {
        $user = Manager::findOne(Yii::$app->user->identity->id);
        $user->visit_count = $user->visit_count + 1;
        $user->last_ip     = Yii::$app->request->userIP;
        $user->last_time   = time();
        $user->save();
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
            $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
            $this->auth_key   = Yii::$app->security->generateRandomString();
        }
        else
        {

            //验证密码是否修改
            $old_pwd = self::getPass($this->id);
            $new_pwd = $this->password_hash;

            if($old_pwd != $new_pwd)
            {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
                $this->auth_key   = Yii::$app->security->generateRandomString();
            }
        }
        return parent::beforeSave($insert);
    }
    /**
     * @param $permissionName 访问地址 控制器/方法
     * @return bool
     * @User:五更的猫
     * @DateTime: 2023/6/5 11:44
     * @TODO 判断访问权限
     */
    public function isRole($permissionName){
        $model = Actions::findOne(['type'=>2,'url'=>$permissionName]);
        //没有设置的接口默认有权限
        if(empty($model)){
            return true;
        }
        //无角色的直接无权访问
        if($this->role_id==0){
            return false;
        }

        if(ActionsRule::find()->andWhere(['role_id'=>$this->role_id,'operate_id'=>$model->id])->exists()){
            return true;
        }
        return false;
    }
    public static function getName($uid){
        if($model = self::findOne($uid))
        {
            return $model['username'];
        }
        if($uid == 0){
            return '未关联';
        }else{
            return '未知用户';
        }
    }

    public static function getPass($uid){
        if($model = self::findOne($uid))
        {
            return $model['password_hash'];
        }
        return false;
    }


    public function getRoleName(){

        if($this->id==Yii::$app->params['adminAccount']){
            return '超级管理员';
        }else {
            if ($this->managerRole['name']) {
                return $this->managerRole['name'];
            }
            return '未设置身份';
        }
    }


    public function getImg()
    {
        if(!empty($this->head_portrait)) {

            if (stripos($this->head_portrait, 'http') !== 0) {
                $this->head_portrait = Yii::$app->request->hostInfo . $this->head_portrait;
            }
            return $this->head_portrait;

        }
        return Yii::$app->request->hostInfo .Yii::getAlias('@index').'/images/touxiang.png';
    }

    /*
    获取会员列表
     */
    public static function getList()
    {
        $model = self::find()->asArray()->all();
        return ArrayHelper::map($model,'id','username');
    }
    public static function IsArchives($id){
        $model = self::findOne(['id'=>$id]);

        if(!empty($model)){
            return $model->is_archives;
        }
        return 2;
    }


    /**
     * @return string
     * User:五更的猫
     * DateTime:2020/9/4 9:21
     * TODO 获取TOKEN
     */
    public function getToken($exp=0){

        $header = array(
            'alg' => Yii::$app->params['JWT']['alg'],
            'typ' => 'JWT'
        );

        if(empty($exp)){
            $exp = Yii::$app->params['JWT']['exp'];
        }

        //iss（签发者），exp（过期时间），sub（面向的用户），aud（接收方），iat（签发时间），device_uuid（设备唯一码）
        $payload = array(
            'iss' => Yii::$app->request->hostInfo,
            'exp' => time() + $exp,
            'sub' => $this->id,
            'hash' => $this->password_hash,//验证是否修改密码
            'iat' => time(),
            'type'=>3//用户类型  1：员工 2：会员  3：后台
        );
        $header = base64_encode(json_encode($header));
        $payload = base64_encode(json_encode($payload));
        $sign = hash_hmac(Yii::$app->params['JWT']['alg'], $header . $payload, Yii::$app->params['JWT']['key']);

        return $header . '.' . $payload . '.' . $sign;

    }




}
