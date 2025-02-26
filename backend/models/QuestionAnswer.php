<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%question_answer}}".
 *
 * @property string $id
 * @property string $name
 * @property string $position
 * @property string $content
 * @property string $question_id
 * @property string $head_image
 * @property string $author_id
 * @property string $created_at
 * @property string $updated_at
 */
class QuestionAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question_answer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'author_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'position'], 'string', 'max' => 100],
            [['content'], 'string', 'max' => 1000],
            [['head_image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'position' => '职位',
            'content' => '内容',
            'question_id' => '问题',
            'head_image' => '头像',
            'author_id' => '作者id',
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


    public function getQuestion(){
        return $this->hasOne(Question::class,['id'=>'question_id']);
    }
}
