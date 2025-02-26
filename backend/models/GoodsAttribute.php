<?php

namespace backend\models;

use common\components\CommonFunction;
use Yii;
use yii\base\BaseObject;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%goods_attribute}}".
 *
 * @property integer $id
 * @property string $code_id
 * @property string $title
 * @property string $content
 * @property string $sort
 * @property string $value
 */
class GoodsAttribute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods_attribute}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','value'], 'required'],
            [['code_id'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 50],
            [['content'], 'string', 'max' => 255],
            [['sort','value'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_id' => '编码',
            'title' => '名称',
            'content' => '备注',
            'sort' => '排序',
            'value' => '属性值',
        ];
    }

    /**
    * @return array
    */



    public static function add_model($message){
        $re=[
            'error'=>0,
            'message'=>'',
        ];
        $goods_sku=new GoodsAttribute();
        $goods_sku->setAttributes($message);
        $goods_sku->value=serialize($message['value']);
        if(!$goods_sku->save()){
            $errors=$goods_sku->getFirstErrors();
            $re['error']=1;
            $re['message']=reset($errors);
        }
        return $re;
    }



    public static function update_model($message){
        $re=[
            'error'=>0,
            'message'=>'',
        ];
        if(!$message['id']){
            $re['error']=1;
            $re['message']='id不正确';
        }else{
            $goods_sku=GoodsAttribute::findOne($message['id']);
            if(!$goods_sku){
                $re['error']=1;
                $re['message']='id不正确';
            }else{
                $goods_sku->setAttributes($message);
                if(isset($message['value'])){
                    $goods_sku->value=serialize($message['value']);
                }

                if(!$goods_sku->save()){
                    $errors=$goods_sku->getFirstErrors();
                    $re['error']=1;
                    $re['message']=reset($errors);
                }
            }

        }

        return $re;
    }


    //处理数据
    public static function model_message($model){
        $arr=[];

        foreach ($model as $k=>$v){
            if ($k=='value'){
                $arr[$k]=unserialize($v);

            }else{
                $arr[$k]=$v;
            }
        }
        return $arr;
    }
}
