<?php

namespace backend\models;

use common\components\CommonFunction;
use common\components\Helper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%sku}}".
 *
 * @property integer $id
 * @property string $goods_id
 * @property string $attributes
 * @property string $sku_id
 * @property string $title
 * @property string $code_id
 * @property double $factory_price
 * @property double $cost_price
 * @property integer $price_level
 * @property integer $min_number
 * @property string $sign
 * @property string $unit
 * @property integer $status
 * @property integer $number
 * @property integer $sales
 * @property string $fixed_price
 * @property integer $is_html
 * @property integer $sort
 * @property integer $sku_limit
 * @property integer $sku_min
 * @property string $price
 * @property string $weight
 * @property string $image
 */
class Sku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sku}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sku_id'],'required'],
            [['goods_id', 'price_level', 'min_number', 'number', 'sales', 'is_html', 'sort', 'sku_limit', 'sku_min','status'], 'integer'],
            [['factory_price', 'cost_price', 'price', 'weight','market_price'], 'number'],
            [['title', 'sign', 'fixed_price', 'image'], 'string', 'max' => 255],
            [['sku_id'], 'string', 'max' => 100],
            [['code_id', 'unit'], 'string', 'max' => 50],
            [['attributes'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '产品id',
            'attributes' => '规格属性',
            'sku_id' => 'sku编码',
            'title' => 'sku名称',
            'code_id' => '产品编码',
            'factory_price' => '出厂价',
            'cost_price' => '成本价',
            'price_level' => '价格体系',
            'min_number' => '最小包装数量',
            'sign' => '图标',
            'unit' => '计量单位',
            'status' => '状态',
            'number' => '库存',
            'sales' => '销量',
            'fixed_price' => '一口价',
            'is_html' => '前台是否可见',
            'sort' => '排序',
            'sku_limit' => '库存紧张参数',
            'sku_min' => '起订量',
            'price' => '价格',
            'weight' => '重量(千克)',
            'image' => '图片',
        ];
    }

    public static function getList($where,$limit=0){
        if($limit>0){
            $model=Sku::find()->where($where)->limit($limit)->orderBy('sort asc,id asc')->all();
        }else{
            $model=Sku::find()->where($where)->orderBy('sort asc,id asc')->all();
        }
        return $model;
    }


    public static function model_message($model){
        $arr=[];

        foreach ($model as $k=>$v){
            if($k=='created_at' or $k=='updated_at'){
                if($v>0){
                    $arr[$k]=date('Y-m-d',$v);
                }else{
                    $arr[$k]='';
                }
            }elseif ($k=='attributes'){
                $arr[$k]=unserialize($v);

            }elseif ( $k=='image'){

                $arr_image=explode(',',$v);
                $arr_image_value=[];
                foreach ($arr_image as $k2=>$v2){
                    $arr_image_value[]=CommonFunction::setImg($v2);
                }
                $arr[$k]=implode(',',$arr_image_value);
            }else{
                $arr[$k]=$v;
            }
        }
        return $arr;
    }


    public function beforeSave($insert)
    {

        if($this->sku_id){
            $goods=Goods::findOne($this->goods_id);
            $url = "https://openapi.jushuitan.com/open/jushuitan/itemsku/upload";
            $sku_attribute=implode(';',unserialize($this->attributes));
            $now = [
                'items' => [
                    0 => [
                        'i_id' =>$this->sku_id,
                        'name' => $goods->title.$sku_attribute,
                        'sku_id' => $this->sku_id,
                        's_price'=>$this->price,
                        'properties_value'=>$sku_attribute,
                        'weight'=>$this->weight,
                    ],

                ]
            ];
            $message = json_encode($now);
            $key = "ab5e1efa1cdc43319cb725d15aa31d7e";
            $secret = "b9c6e6d186b248aba07b12ba9af7c1b5";
            $token = "935971e0f86648a28d3d8244341b5a1d";
            $time = time();
            $sign = md5($secret . 'access_token' . $token . 'app_key' . $key . 'biz' . $message . "charsetutf-8" . "timestamp" . $time . 'version2');
            $params = [
                'app_key' => $key,
                'access_token' => $token,
                'timestamp' => $time,
                'charset' => 'utf-8',
                'version' => 2,
                'sign' => $sign,
                'biz' => $message,
            ];


            $params = http_build_query($params);
            Helper::httpPost($url,$params);
        }


        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }






}
