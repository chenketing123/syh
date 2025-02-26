<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%team}}".
 *
 * @property string $id
 * @property string $title
 * @property string $type
 * @property string $book_id
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team}}';
    }


    public static $type_message=[
        1=>'小组',
        2=>'团队',
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type','book_id'], 'integer'],
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
            'type' => '类型',
            'book_id'=>'阅读书籍'
        ];
    }

    public function getBook(){
        return $this->hasOne(Book::class,['id'=>'book_id']);
    }


    //删除后处理
    public function afterDelete()
    {
        parent::beforeDelete();
        //$this->id;
        TeamDetail::deleteAll(['team_id'=>$this->id]);
        UserTeam::deleteAll(['team_id'=>$this->id]);
        UserCheck::deleteAll(['relation_id'=>$this->id]);
        //在这里做删除前的事情
        return true;
    }

    public static function getList()
    {
        $model = self::find()->orderBy('id desc')->asArray()->all();
        return ArrayHelper::map($model, 'id', 'title');
    }



}
