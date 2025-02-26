<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%activity_user}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $activity_id
 * @property string $mobile
 * @property string $name
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class ActivityUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%activity_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'activity_id', 'status'], 'integer'],
            [['mobile', 'name'], 'string', 'max' => 50],
            [['price','order_number','paid_time','is_kb'],'safe'],
        ];
    }

    public static $status_message=[
        1=>'未签到',
        2=>'已签到'
    ];

    public static $pay_message=[
        1=>'未支付',
        2=>'已支付'
    ];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'activity_id' => '活动',
            'mobile' => '电话',
            'name' => '姓名',
            'status' => '状态',
            'created_at' => '添加时间',
            'updated_at' => 'Updated At',
            'price'=>'价格',
            'order_number'=>'订单编号',
            'paid_time'=>'支付时间',
            'check_time'=>'签到时间',
            'pay_status'=>'支付状态',
            'is_kb'=>'是否空巴'
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function getUser(){
        return $this->hasOne(User::class,['id'=>'user_id']);
    }
    public function getActivity(){
        return $this->hasOne(Activity::class,['id'=>'activity_id']);
    }
}
