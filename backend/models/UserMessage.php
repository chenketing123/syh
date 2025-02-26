<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_message}}".
 *
 * @property string $id
 * @property string $message_id
 * @property string $company
 * @property string $money
 * @property string $number
 * @property string $scale
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class UserMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'number', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['money', 'scale'], 'number'],
            [['company'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_id' => '标题',
            'company' => '公司名称',
            'money' => '产值（万元）',
            'number' => '人数',
            'scale' => '规模（平方米）',
            'user_id' => '用户',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
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

    public function getMessage(){
        return $this->hasOne(Message::class,['id'=>'message_id']);
    }

    public function getUser(){
        return $this->hasOne(User::class,['id'=>'user_id']);
    }
}
