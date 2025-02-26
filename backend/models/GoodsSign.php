<?php

namespace backend\models;

use Yii;
use yii\base\BaseObject;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%goods_sign}}".
 *
 * @property string $title
 * @property integer $sort
 * @property integer $is_show
 * @property integer $is_index
 * @property string $is_goods
 */
class GoodsSign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_sign}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'is_show', 'is_index', 'is_goods'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '标题',
            'sort' => '排序',
            'is_show' => 'Is Show',
            'is_index' => 'Is Index',
            'is_goods' => 'Is Goods',
        ];
    }



    public static function add_model($message){

        $re=[
            'error'=>0,
            'message'=>''
        ];
        $model=new GoodsSign();
        $model->setAttributes($message);
        if(!$model->save()){
            $error=$model->getFirstErrors();
            $re['error']=1;
            $re['message']=reset($error);
        }
        return $re;
    }


    public static function update_model($message){

        $re=[
            'error'=>0,
            'message'=>''
        ];
        if(!$message['id']){
            $re['error']=1;
            $re['message']='id不正确';
        }else{
            $model=GoodsSign::findOne($message['id']);;
            if(!$model){
                $re['error']=1;
                $re['message']='id不正确';
            }else{
                $model->setAttributes($message);
                if(!$model->save()){
                    $error=$model->getFirstErrors();
                    $re['error']=1;
                    $re['message']=reset($error);
                }
            }


        }
        return $re;

    }

}
