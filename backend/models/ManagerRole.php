<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%employee_role}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $append
 * @property integer $updated
 */
class ManagerRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manager_role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['append', 'updated'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
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
        ManagerMenuRule::deleteAll(['role_id'=>$this->id]);
        ActionsRule::deleteAll(['role_id'=>$this->id]);
        //在这里做删除前的事情
        return true;
    }

    public static function getList(){
        return self::find()->indexBy('id')->select('name')->asArray()->column();
    }
    public static function getName($id){
        if($id == 0){
            return '无';
        }
        $model = self::findOne(['id'=>$id]);
        if(!empty($model)){
            return $model->name;
        }
        return '未知角色';
    }
}
