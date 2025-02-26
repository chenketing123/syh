<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%menu_rule}}".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $menu_id
 */
class ManagerMenuRule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manager_menu_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'menu_id'], 'required'],
            [['role_id', 'menu_id'], 'integer'],
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
            'menu_id' => '菜单',
        ];
    }

    /**
     * @param $role_id
     * @param $menus
     * @return true
     * @User:五更的猫
     * @DateTime: 2023/6/5 9:57
     * @TODO 设置菜单权限
     */
    public function setMenus($role_id,$menus)
    {
        //删除原先用户的所有用户菜单
        $this::deleteAll(['role_id'=>$role_id]);
        foreach ($menus as $value)
        {
            $MenuChild = new $this;
            $MenuChild->menu_id  = $value;
            $MenuChild->role_id     = $role_id;
            $MenuChild->save();
        }

        return true;
    }
}
