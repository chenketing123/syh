<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%message}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $sort
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['path','type'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'sort' => '排序',
            'type'=>'类型',
            'path'=>'其他小程序链接'
        ];
    }

    public static function getList()
    {
        $model = self::find()->orderBy('sort asc,id desc')->asArray()->all();
        return ArrayHelper::map($model, 'id', 'title');
    }


}
