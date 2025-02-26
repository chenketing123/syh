<?php

namespace backend\models;

use common\components\CommonFunction;
use common\extensions\sms\Sms;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%codes}}".
 *
 * @property string $id
 * @property string $phone
 * @property integer $code
 * @property integer $status
 * @property string $append
 * @property string $updated
 */
class Codes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%codes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'code'], 'required'],
            [['code', 'status', 'append', 'updated'], 'integer'],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => '手机号',
            'code' => '验证码',
            'status' => '状态',
            'append' => '添加时间',
            'updated' => '修改时间',
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['append', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],
            ],
        ];
    }

    /**
     * @param string $phone
     * @param int    $len
     *
     * @return array
     * 添加验证码
     */
    public static function addCode($phone='',$len=4){
        $error = array('errcode'=>1,'errmsg'=>'失败');
        if(!empty($phone)){
            $data = self::find()->where(['phone'=>$phone,'status'=>0])->orderBy('append desc,id desc')->one();
            if(1 || ($data['append']+60) <time()){
                $code = CommonFunction::random($len);
                //$code = '666666';
                $model = new Codes();
                $model->phone = $phone;
                $model->code = $code;
                if($model->save()){

                    $sms = new Sms();

                    if($sms->sendCodeSMS3($phone,array('code'=>$code))){
                        $error = array('errcode'=>0,'errmsg'=>'发送成功');
                    }else{
                        self::findOne($model->id)->delete();
                        $error['errmsg'] = '发送失败，错误信息：'.$sms->errmsg;
                    }
                }
            }else{
                $error['errmsg'] = '请勿重复发送验证码';
            }
        }
        return $error;
    }

    /**
     * @param string $phone
     * @param string $code
     *
     * @return array
     * 验证验证码
     */
    public static function getCode($phone='',$code=''){
        $error = array('errcode'=>1,'errmsg'=>'未填写手机号验证码');
        if(!empty($phone) && !empty($code)){
            $data = self::find()->where(['phone'=>$phone,'status'=>0])->orderBy('append desc,id desc')->one();
            if(!empty($data)){
                if(($data['append']+600) >time()){
                    if($data['code'] == $code){
                        $data->status = 1;
                        $data->save();
                        $error = array('errcode'=>0,'errmsg'=>'验证成功');
                    }else{
                        $error['errmsg'] = '验证码错误';
                    }
                }else{
                    $error['errmsg'] = '验证码已过期';
                }
            }else{
                $error['errmsg'] = '没有发送验证码';
            }
        }
        return $error;
    }
}
