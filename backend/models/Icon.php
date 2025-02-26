<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%icon}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property integer $type
 * @property string $href
 * @property string $appid
 * @property integer $sort
 */
class Icon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%icon}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'sort'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['image', 'href', 'appid'], 'string', 'max' => 255],
        ];
    }

    public static $type_message=[
        1=>'小程序内部',
        2=>'外部小程序',
        3=>'外部网站'
    ];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'image' => '图片',
            'type' => '类型',
            'href' => '链接数据',
            'appid' => '小程序appid',
            'sort' => '排序',
        ];
    }
}
