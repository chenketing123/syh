<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%team_detail}}".
 *
 * @property string $id
 * @property string $team_id
 * @property string $title
 */
class TeamDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_id'], 'integer'],
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
            'team_id' => 'Team ID',
            'title' => 'Title',
        ];
    }

    //删除后处理
    public function afterDelete()
    {
        parent::beforeDelete();

        UserTeam::updateAll(['detail_id'=>0],['detail_id'=>$this->id]);
        //在这里做删除前的事情
        return true;
    }

}
