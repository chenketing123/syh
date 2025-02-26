<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%order_detail}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $order_id
 * @property integer $goods_id
 * @property integer $number
 * @property string $price
 * @property string $market_price
 * @property string $content
 * @property string $weight
 * @property string $sku
 * @property string $image
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'order_id', 'goods_id', 'number'], 'required'],
            [['order_id', 'goods_id', 'number'], 'integer'],
            [['price', 'market_price', 'weight'], 'number'],
            [['content'], 'string'],
            [['title', 'sku', 'image'], 'string', 'max' => 255],
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
            'order_id' => '订单id',
            'goods_id' => '产品id',
            'number' => '数量',
            'price' => '价格',
            'market_price' => '原价',
            'content' => '备注',
            'weight' => '重量',
            'sku' => '规格型号',
            'image' => '产品图片',
        ];
    }


}
