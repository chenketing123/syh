<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%team_book}}".
 *
 * @property string $id
 * @property string $team_id
 * @property string $book_id
 * @property string $detail_id
 * @property string $time
 */
class TeamBook extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%team_book}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['team_id', 'book_id', 'detail_id', 'time'], 'integer'],
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
            'book_id' => 'Book ID',
            'detail_id' => 'Detail ID',
            'time' => 'Time',
        ];
    }

    public function getBook(){
        return $this->hasOne(Book::class,['id'=>'book_id']);
    }

    public function getDetail(){
        return $this->hasOne(BookDetail::class,['id'=>'detail_id']);
    }
}
