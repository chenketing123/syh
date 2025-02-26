<?php

namespace backend\models;

use common\components\CommonFunction;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%practice}}".
 *
 * @property string $id
 * @property string $category_id
 * @property string $title
 * @property string $start_time
 * @property string $end_time
 * @property string $image
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class Practice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%practice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id','sort'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['image'], 'string', 'max' => 255],
            [['start_time','end_time'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '分类',
            'title' => '标题',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'image' => '图片',
            'content' => '内容',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
            'sort'=>'排序'
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
        return $this->hasOne(PracticeCategory::class,['id'=>'category_id']);
    }

    public function beforeSave($insert)
    {

        if($this->image){
            $this->image=CommonFunction::unsetImg($this->image);
        }
        if(!is_numeric($this->start_time)){
            $this->start_time=strtotime($this->start_time);
        }
        if(!is_numeric($this->end_time)){
            $this->end_time=strtotime($this->end_time);
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public static function getList()
    {
        $model = self::find()->orderBy('sort asc,id desc')->asArray()->all();
        return ArrayHelper::map($model, 'id', 'title');
    }

}
