<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%actions}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $type
 * @property string $name
 * @property string $url
 * @property integer $level
 * @property integer $sort
 * @property integer $append
 * @property integer $updated
 */
class Actions extends \yii\db\ActiveRecord
{
    public static $type = [
        1=>'目录',
        2=>'权限'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%actions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'type', 'level', 'sort', 'append', 'updated'], 'integer'],
            [['name'], 'required'],
            [['name', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '上级',
            'type' => '类型',
            'name' => '名称',
            'url' => '路由',
            'level' => '等级',
            'sort' => '排序',
            'append' => '添加时间',
            'updated' => '修改时间',
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }
    //删除后处理
    public function afterDelete()
    {
        parent::beforeDelete();
        //$this->id;
        ActionsRule::updateAll(['operate_id'=>$this->id]);

        //在这里做删除前的事情
        return true;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionsRule()
    {
        return $this->hasMany(ActionsRule::className(), ['operate_id' => 'id']);
    }

    public static function getName($id){
        $model = self::findOne($id);
        if(!empty($model)){
            return $model->name;
        }
        return $id==0?'无':'未知权限';
    }
}
