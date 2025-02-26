<?php

namespace backend\models;

use common\components\CommonFunction;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%goods_sku}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $sort
 * @property string $value
 * @property string $goods_id
 */
class GoodsSku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_sku}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'value'], 'required'],
            [['sort', 'goods_id','model_id'], 'integer'],
            [['value'], 'string'],
            [['title'], 'string', 'max' => 50],
            [['content'], 'string', 'max' => 255],
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
            'content' => '备注',
            'sort' => '排序',
            'value' => '属性值',
            'goods_id' => '产品id',
        ];
    }

    public static function getList($where,$limit=0){
        if($limit>0){
            $model=GoodsSku::find()->where($where)->limit($limit)->orderBy('sort asc,id asc')->all();
        }else{
            $model=GoodsSku::find()->where($where)->orderBy('sort asc,id asc')->all();
        }
        return $model;
    }

    public static function model_message($model){
        $arr=[];

        foreach ($model as $k=>$v){
            if ($k=='value'){
                if($v){
                    $arr[$k]=unserialize($v);
                }else{
                    $arr[$k]=$v;
                }


            }else{
                $arr[$k]=$v;
            }
        }
        return $arr;
    }

}
