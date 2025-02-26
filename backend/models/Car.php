<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%car}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $car_number
 * @property string $type
 * @property string $brand
 * @property string $car_type
 * @property string $insurer
 * @property string $frame
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%car}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'integer'],
            [['car_number', 'brand', 'car_type', 'insurer'], 'string', 'max' => 50],
            [['frame'], 'string', 'max' => 255],
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
            'car_number' => '车牌号',
            'type' => '类型',
            'brand' => '品牌',
            'car_type' => '车型',
            'insurer' => '车架号',
            'frame' => '保险公司',
        ];
    }

    /**
    * @return array
    */
}
