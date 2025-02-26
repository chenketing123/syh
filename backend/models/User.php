<?php

namespace backend\models;

use common\components\CommonFunction;
use common\components\Helper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $mobile_phone
 * @property integer $sex
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $integral
 * @property integer $end_time
 * @property string $company_phone
 * @property string $head_image
 * @property string $status
 * @property string $password
 * @property string $douyin
 */
class User extends \common\models\User
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'type', 'status','is_vip','age','is_answer'], 'integer'],
            [['mobile_phone'],'unique','message'=>'手机号已经存在'],
            [['integral'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['mobile_phone', 'company_phone'], 'string', 'max' => 20],
            [['head_image', 'password', 'douyin'], 'string', 'max' => 255],
            [['start_time','end_time','company_image','position','openid'],'safe'],
            [['company', 'dmts', 'fhmc', 'hubh', 'snzy', 'zw', 'sex_value', 'id_card', 'zb', 'csny', 'jl', 'xsskc', 'xl', 'scjf', 'yf', 'hfdq', 'nxse', 'ygs', 'hy', 'goods', 'sfss', 'sssj', 'email', 'gsqy', 'gsdz', 'sjrdz', 'sjrxm', 'sjrdh', 'tjr', 'jjlxr', 'qylxr', 'sfkp', 'kpzl', 'dytj'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '姓名',
            'mobile_phone' => '手机',
            'sex' => '性别',
            'type' => 'Type',
            'updated_at' => 'Updated At',
            'integral' => '积分',
            'company_phone' => '单位电话',
            'head_image' => '头像',
            'status' => 'Status',
            'password' => 'Password',
            'douyin' => '抖音号',
            'is_vip'=>'会员',
            'start_time'=>'会员开始时间',
            'end_time'=>'会员结束时间',
            'is_answer'=>'可回答问题',
            'company_image'=>'公司图片',
            'company'=>'公司名称',
            'business'=>'主营业务',
            'age'=>'年龄',
            'position'=>'职业',
            'created_at'=>'添加时间',
            'dmts' => '稻米天使',
            'fhmc' => '分会名称',
            'hubh' => '会员编号',
            'snzy' => '塾内职务',
            'zw' => '职务',
            'sex_value' => '性别',
            'id_card' => '身份证号码',
            'zb' => '组别',
            'csny' => '出生年月',
            'year' => '年',
            'month' => '月',
            'day' => '日',
            'jl' => '旧历',
            'xsskc' => '新塾生课程',
            'xl' => '学历',
            'scjf' => '首次缴费日期',
            'yf' => '月份',
            'hfdq' => '会费到期时间',
            'nxse' => '年销售额',
            'ygs' => '员工数',
            'hy' => '行业',
            'goods' => '产品',
            'sfss' => '是否上市',
            'sssj' => '上市时间',
            'email' => 'e-mail',
            'gsqy' => '公司区域',
            'gsdz' => '公司地址',
            'sjrdz' => '收件人地址',
            'sjrxm' => '收件人姓名',
            'sjrdh' => '收件人电话',
            'tjr' => '推荐人',
            'jjlxr' => '紧急联系人',
            'qylxr' => '企业联系人',
            'sfkp' => '是否开票',
            'kpzl' => '开票资料',
            'dytj' => '对应推荐稻米天使',
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

    public function getToken($exp=0){

        $header = array(
            'alg' => Yii::$app->params['JWT']['alg'],
            'typ' => 'JWT'
        );

        if(empty($exp)){
            $exp = Yii::$app->params['JWT']['exp'];
        }

        //iss（签发者），exp（过期时间），sub（面向的用户），aud（接收方），iat（签发时间），device_uuid（设备唯一码）
        $payload = array(
            'iss' => Yii::$app->request->hostInfo,
            'exp' => time() + $exp,
            'sub' => $this->id,
            'hash' => $this->password,//验证是否修改密码
            'iat' => time(),
            'type'=>1//用户类型  1：员工 2：会员  3：后台
        );
        $header = base64_encode(json_encode($header));
        $payload = base64_encode(json_encode($payload));
        $sign = hash_hmac(Yii::$app->params['JWT']['alg'], $header . $payload, Yii::$app->params['JWT']['key']);

        return $header . '.' . $payload . '.' . $sign;

    }


    public function getImg()
    {
        if(!empty($this->head_image)) {

            if (stripos($this->head_image, 'http') !== 0) {
                $this->head_image = Yii::$app->request->hostInfo . $this->head_image;
            }
            return $this->head_image;

        }
        return Yii::$app->request->hostInfo .Yii::getAlias('@index').'/images/touxiang.png';
    }


    public function beforeSave($insert)
    {

        if($this->head_image){
            $this->head_image=CommonFunction::unsetImg($this->head_image);
        }
        if(!$this->head_image){
            $this->head_image='/touxiang.jpg';
        }
        if($this->isNewRecord){
            if(!$this->name){
                $this->name=$this->mobile_phone;
            }
        }
        if(is_array($this->company_image)){
            $this->company_image=implode(',',$this->company_image);
        }
        if(!is_numeric($this->start_time)){
            $this->start_time=strtotime($this->start_time);
        }
        if(!is_numeric($this->end_time)){
            $this->end_time=strtotime($this->end_time);
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => 1]);
    }


    //处理数据
    public static function model_message($model){
        $arr=[];
        foreach ($model as $k=>$v){
            if($k=='created_at' or $k=='updated_at' or $k=='end_time' or $k=='time' or $k=='start_time' or $k=='end_time' ){
                if($v>0){
                    $arr[$k]=date('Y-m-d',$v);
                }else{
                    $arr[$k]='';
                }
            }elseif ($k=='category_id'){
                $arr[$k]=$v;
                $arr['category_title']=$model->category['title'];
            }elseif ($k=='user_id'
            ){
                $arr[$k]=$v;
                $name=$k.'_name';
                $user=User::findOne($v);
                if($user){
                    $arr[$name]=$user['name'];
                }else{
                    $arr[$name]=$v;
                }
            }elseif ($k=='book_id'
            ){
                $arr[$k]=$v;
                $name=$k.'_name';
                $book=Book::findOne($v);
                if($book){
                    $arr[$name]=$book['title'];
                }else{
                    $arr[$name]=$v;
                }
            }elseif ($k=='file' or $k=='file_url' or $k=='image' or $k=='head_image' or $k=='more_image' or $k=='goods_image'){

                $arr_image=explode(',',$v);
                $arr_image_value=[];
                foreach ($arr_image as $k2=>$v2){
                    $arr_image_value[]=CommonFunction::setImg($v2);
                }
                $arr[$k]=implode(',',$arr_image_value);
            }elseif ($k=='company_image'){

                if($v){
                    $arr_image=explode(',',$v);
                    $arr_image_value=[];
                    if(count($arr_image)>0){
                        foreach ($arr_image as $k2=>$v2){
                            $arr_image_value[]=CommonFunction::setImg($v2);
                        }
                    }

                    $arr[$k]=$arr_image_value;
                }else{
                    $arr[$k]=[];
                }

            }elseif ($k=='content' or $k=='info'){
                $arr[$k]=Helper::imageUrl2($v);
            }elseif ($k=='admin_id'){
                if($v>0){
                    $xg_user=Manager::findOne($v);
                    $arr['xg_name']=$xg_user['username'];
                }

            }else{
                $arr[$k]=$v;
            }
        }
        return $arr;
    }




    public static function getList()
    {
        $model = self::find()->orderBy('id asc')->asArray()->all();
        $arr=[];
        foreach ($model as $k=>$v){
            $arr[$v['id']]=$v['name'].'-'.$v['mobile_phone'];
        }
        return $arr;
    }
}
