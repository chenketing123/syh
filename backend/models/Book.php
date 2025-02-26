<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%book}}".
 *
 * @property string $id
 * @property string $title
 * @property integer $sort
 * @property string $image
 * @property string $category_id
 * @property string $author
 * @property string $created_at
 * @property string $updated_at
 * @property string $info
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%book}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'category_id','read_number'], 'integer'],
            [['info'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['image'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 50],
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
            'image' => '图片',
            'category_id' => '分类',
            'author' => '作者',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
            'info' => '简介',
            'read_number'=>'阅读人数'
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

    public static function getList()
    {
        $model = self::find()->orderBy('sort asc,id desc')->asArray()->all();
        return ArrayHelper::map($model, 'id', 'title');
    }


    public function getCategory(){
        return $this->hasOne(BookCategory::class,['id'=>'category_id']);
    }


}
