<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%book_category}}".
 *
 * @property string $id
 * @property string $title
 * @property integer $sort
 */
class BookCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort'], 'integer'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '名称',
            'sort' => '排序',
        ];
    }

    public static function getList(){
        $model=BookCategory::find()->select(['id','title'])->orderBy('sort asc,id desc')->asArray()->all();
        return ArrayHelper::map($model,'id','title');
    }

}
