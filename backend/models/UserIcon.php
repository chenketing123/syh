<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_icon}}".
 *
 * @property string $id
 * @property string $title
 * @property string $image
 * @property integer $sort
 * @property string $type
 */
class UserIcon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_icon}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'type'], 'integer'],
            [['title', 'image','image2'], 'string', 'max' => 255],
        ];
    }


    public static $type_message=[
        1=>'打卡1次',
        2=>'阅读一次',
        3=>'完成必学课程',
        4=>'参加活动',
        5=>'提出问题'
    ];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'image' => '达成图片',
            'image2' => '未达成图片',
            'sort' => '排序',
            'type' => '类型',
        ];
    }


}
