<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%provinces}}".
 *
 * @property integer $id
 * @property string $areaname
 * @property integer $parentid
 * @property string $shortname
 * @property integer $areacode
 * @property integer $zipcode
 * @property string $pinyin
 * @property string $lng
 * @property string $lat
 * @property integer $level
 * @property string $position
 * @property integer $sort
 */
class Provinces extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%provinces}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'areaname', 'parentid', 'level', 'position'], 'required'],
            [['id', 'parentid', 'areacode', 'zipcode', 'level', 'sort'], 'integer'],
            [['areaname', 'shortname'], 'string', 'max' => 50],
            [['pinyin'], 'string', 'max' => 100],
            [['lng', 'lat'], 'string', 'max' => 20],
            [['position'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'areaname'  => '名称',
            'parentid'  => '父级ID',
            'shortname' => '简称',
            'areacode'  => '区域编号',
            'zipcode'   => '邮编',
            'pinyin'    => '拼音',
            'lng'       => 'Lng',
            'lat'       => 'Lat',
            'level'     => '级别',
            'position'  => 'Position',
            'sort'      => '排序',
        ];
    }

    public function getChildren(){
        return $this->hasMany(Provinces::className(), ['parentid' => 'id']);
    }


    /**
     * @param int $parentid
     * @return array
     * 根据父级ID返回信息
     */
    public static function getCityList($parentid = 0)
    {
        $model = Provinces::findAll(['parentid'=>$parentid]);
        return ArrayHelper::map($model,'id','areaname');
    }

    /**
     * @param int $parentid
     * @return array
     * 根据父级ID返回信息
     */
    public static function getLiveList($parentid = 0)
    {
        return self::find()->where(['parentid'=>$parentid])->indexBy('id')->select('areaname')->column();
    }


    /**
     * @param int $parentid
     * @return array
     * 根据ID返回城市简称
     */
    public static function getName($id = 0,$default='未选择')
    {
        $model = Provinces::findOne($id);
        if(!empty($model)){
            return $model->shortname;
        }
        return $id==0?$default:'未知';
    }

    /**
     * @param int $parentid
     * @return array
     * 根据ID返回城市全称
     */
    public static function getName2($id = 0,$default='未选择')
    {
        $model = Provinces::findOne($id);
        if(!empty($model)){
            return $model->areaname;
        }
        return $id==0?$default:'未知';
    }

    /**
     * @param string $name
     *
     * @return bool
     * 获取区域ID
     *
     */
    public static function getID($name='',$level=0){
        $name = str_replace('省','',$name);
        $name = str_replace('市','',$name);
        $name = str_replace('区','',$name);

        if(!empty($name)){
            $data = self::find()->where(['or',['like','areaname',$name],['like','shortname',$name]]);
            if(!empty($level) && in_array($level,array(1,2,3))){
                $data->andWhere(['level'=>$level]);
            }
            $model = $data->one();
            if(!empty($model)){
                return $model['id'];
            }
        }
        return 0;
    }


    /**
     * @param int $parentid
     * @return array
     * 根据ID返回城市全称
     */
    public static function getNameDefault($id = 0,$Default='')
    {
        $model = Provinces::findOne($id);
        if(!empty($model)){
            return $model->areaname;
        }
        return $id==0?$Default:'未知';
    }
}
