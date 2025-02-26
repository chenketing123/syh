<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%question}}".
 *
 * @property string $id
 * @property string $title
 * @property string $user_id
 * @property string $hit
 * @property string $answer
 * @property string $category_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $type
 * @property string $like
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'hit', 'answer', 'category_id', 'created_at', 'updated_at', 'type', 'like','status'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 1000],
            [['name','position','head_image'],'safe']
        ];
    }

    public static $status_message=[
        1=>'待审核',
        2=>'审核通过',
        3=>'审核不通过',
    ];

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'user_id' => '用户',
            'hit' => '点击量',
            'answer' => '回答数',
            'category_id' => '分类',
            'content' => '内容',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
            'type' => '类型',
            'like' => '点赞量',
            'status'=>'状态',
            'name'=>'姓名',
            'position'=>'职称',
            'head_image'=>'头像'
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


    public function getCategory(){
        return $this->hasOne(QuestionCategory::class,['id'=>'category_id']);
    }


    public function getUser(){
        return $this->hasOne(User::class,['id'=>'user_id']);
    }


    public static function getList()
    {
        $model = self::find()->orderBy('id asc')->asArray()->all();
        return ArrayHelper::map($model, 'id', 'content');
    }

    public static function getList2()
    {
        $model = self::find()->orderBy('id asc')->asArray()->all();
        return ArrayHelper::map($model, 'id', 'title');
    }


}
