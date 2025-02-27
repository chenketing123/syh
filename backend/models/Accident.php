<?php

namespace backend\models;

use common\components\CommonFunction;
use common\components\Helper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%accident}}".
 *
 * @property string $id
 * @property string $user_id
 * @property string $image
 * @property string $type
 * @property string $road
 * @property string $direction
 * @property string $location
 * @property string $lng
 * @property string $lat
 * @property integer $occupy
 * @property string $car_number
 * @property string $created_at
 * @property string $updated_at
 */
class Accident extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%accident}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image','type','road','direction','location','lng','lat','occupy','car_number'],'required'],
            [['user_id', 'type', 'road'], 'integer'],
            [['lng','lat'], 'number'],
            [['image'], 'string', 'max' => 1000],
            [['direction', 'location','occupy'], 'string', 'max' => 255],
            [['car_number'], 'string', 'max' => 20],
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
            'image' => '图片',
            'type' => '交通事件',
            'road' => '道路选择',
            'direction' => '方向',
            'location' => '位置',
            'lng' => '经度',
            'lat' => '纬度',
            'occupy' => '占用车道',
            'car_number' => '车牌号',
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


    public function beforeSave($insert)
    {

        if($this->image){
            $arr=explode(',',$this->image);
            $value=[];
            foreach ($arr as $k=>$v){
                $value[]=CommonFunction::unsetImg($v);
            }
            $this->image=implode(',',$value);
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }



}
