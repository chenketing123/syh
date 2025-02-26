<?php

namespace backend\models;

use common\components\CommonFunction;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property integer $id
 * @property string $goods_id
 * @property string $sku
 * @property string $number
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $type
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'number', 'user_id', 'created_at', 'updated_at', 'type'], 'integer'],
            [['sku'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'sku' => 'Sku',
            'number' => 'Number',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'type' => '类型',
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }


    public static function model_message($model){
        $arr=[];
        foreach ($model as $k=>$v){
            if ($k=='sku'){
                if($v){
                    $arr[$k]=unserialize($v);
                }else{
                    $arr[$k]=$v;
                }
            }elseif ($k=='goods_id'){
                $goods=Goods::findOne($v);
                $arr['goods_id']=$v;
                $arr['title']=$goods['title'];
                $arr['image']=CommonFunction::setImg($goods['image']);

            }else{
                $arr[$k]=$v;
            }
        }
        if($model['sku']){
            $sku=Sku::find()->where(['goods_id'=>$model['goods_id'],'attributes'=>$model['sku']])->limit(1)->one();
            $arr['price']=$sku['price'];
            $arr['weight']=$sku['weight'];
        }else{
            $goods=Goods::findOne($model['goods_id']);
            $arr['price']=$goods['price'];
            $arr['weight']=$goods['weight'];
        }
        return $arr;
    }

}
