<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_apply}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $mobile
 * @property string $company
 * @property string $money
 * @property string $number
 * @property string $scale
 * @property string $created_at
 * @property string $updated_at
 */
class UserApply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_apply}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'number', 'created_at', 'updated_at'], 'integer'],
            [['money', 'scale'], 'number'],
            [['name', 'company'], 'string', 'max' => 100],
            [['mobile'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户',
            'name' => '姓名',
            'mobile' => '电话',
            'company' => '公司名称',
            'money' => '产值（万元）',
            'number' => '规模（平方米）',
            'scale' => '公司人数',
            'created_at' => '添加时间',
            'updated_at' => 'Updated At',
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
}
