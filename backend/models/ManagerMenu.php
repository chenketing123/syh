<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%employee_menu}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property string $url
 * @property string $menu_css
 * @property integer $sort
 * @property integer $level
 * @property integer $status
 * @property integer $append
 * @property integer $updated
 */
class ManagerMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manager_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['pid', 'sort', 'level', 'status', 'append', 'updated','is_hidden'], 'integer'],
            [['name', 'url', 'menu_css','title','query'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '菜单全称',
            'name' => '名称',
            'pid' => '上级',
            'url' => '美化路由',
            'component' => '实际路由',
            'query' => '参数',
            'menu_css' => '图标样式',
            'is_hidden'=>'是否菜单显示',
            'sort' => '排序',
            'level' => '等级',
            'status' => '状态',
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
        ManagerMenuRule::updateAll(['menu_id'=>$this->id]);

        //在这里做删除前的事情
        return true;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuRule()
    {
        return $this->hasOne(ManagerMenuRule::className(), ['menu_id' => 'id']);
    }

    public static function getName($id){
        $model = self::findOne($id);
        if(!empty($model)){
            return $model->title;
        }
        return $id==0?'无':'未知菜单';
    }
}
