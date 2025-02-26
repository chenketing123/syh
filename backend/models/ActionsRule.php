<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%actions_rule}}".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $operate_id
 */
class ActionsRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%actions_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'operate_id'], 'required'],
            [['role_id', 'operate_id'], 'integer'],

            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => ManagerRole::className(), 'targetAttribute' => ['role_id' => 'id']],
            [['operate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Actions::className(), 'targetAttribute' => ['operate_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => '角色',
            'operate_id' => '操作',
        ];
    }

    /**
     * @param $parent  -角色名称
     * @param $auth    -所有权限
     * @return bool
     */
    public function accredit($role_id,$auth)
    {
        //删除原先所有权限
        $delete = $this::deleteAll(['role_id' => $role_id]);

        foreach ($auth as $value)
        {
            $AuthItemChild = new $this;
            $AuthItemChild->role_id = $role_id;
            $AuthItemChild->operate_id  = $value;
            $AuthItemChild->save();
        }

        return true;
    }
}
