<?php

namespace backend\models;

use common\components\CommonFunction;
use common\components\JhApi;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "{{%vr}}".
 *
 * @property string $id
 * @property string $title
 * @property string $cover
 * @property string $url
 * @property integer $lang
 * @property string $sort
 * @property integer $status
 * @property string $append
 * @property string $updated
 */
class Lang extends \yii\db\ActiveRecord
{

    public static $value = [
        1=>'中文',
        2=>'英文',
        3=>'日文',
        4=>'韩文'
    ];
    public static $value2 = [
        1=>'中文',
        2=>'English',
        3=>'やまと',
        4=>'한국어 공부 해요'
    ];

    public static $key = [
        1=>'zh-CN',
        2=>'en-CN',
        3=>'ja',
        4=>'ko'
    ];
    public static $key2 = [
        1=>'zh',
        2=>'en',
        3=>'ja',
        4=>'ko'
    ];

    public static $level = [
        0=>'',
        1=>'A',
        2=>'AA',
        3=>'AAA',
        4=>'AAAA',
        5=>'AAAAA',
    ];

    public static $is = [
        1=>'是',
        2=>'否'
    ];

    public static $status = [
        1=>'启用',
        2=>'禁用',
    ];

    /**
     * @return mixed
     * User:五更的猫
     * DateTime:2021/9/9 11:27
     * TODO 网站所有
     */
    public static function getCopyrightAll(){
        switch (CommonFunction::GetLang()){
            case 2:
                return Yii::$app->config->info('COPYRIGHT_ALL_E');
                break;
            case 3:
                return Yii::$app->config->info('COPYRIGHT_ALL_R');
                break;
            case 4:
                return Yii::$app->config->info('COPYRIGHT_ALL_H');
                break;
            default:
                return Yii::$app->config->info('COPYRIGHT_ALL');
                break;
        }
    }

    /**
     * @return array
     * User:五更的猫
     * DateTime:2021/9/10 10:44
     * TODO 获取实时天气数据
     */
    public static function getWeather(){

        $lang = self::$key2[CommonFunction::GetLang()];

        $key = 'CommonFunction_getWeather_date_'.date('Y-m-d').'_lang_'.$lang;

        $return = Yii::$app->cache->get($key);

        if(!empty($return)){
            $return = unserialize($return);
        }

        if(empty($return) || !is_array($return)){

            $url="https://devapi.qweather.com/v7/weather/3d";
            $params=array(
                'key'=>'001c08edb9a24096aed76b09c02d4376',
                'location'=>'101210406',
                'lang'=>$lang
            );
            $weixin=self::http($url,$params,'GET');//通过code换取网页授权access_token
            $data=json_decode($weixin,true); //对JSON格式的字符串进行编码
            $return = array();

            $data2=$data;
            if($lang!='zh'){
                $params=array(
                    'key'=>'001c08edb9a24096aed76b09c02d4376',
                    'location'=>'101210406',
                    'lang'=>'zh'
                );
                $weixin=self::http($url,$params,'GET');//通过code换取网页授权access_token
                $data2=json_decode($weixin,true); //对JSON格式的字符串进行编码
            }

            if(isset($data['daily']) && isset($data2['daily'])){
                foreach ($data['daily'] as $k=>$v){
                    $return[]=array(
                        "date"=>$v['fxDate'],
                        'textDay'=>$v['textDay'],
                        'text'=>$v['tempMin'].'~'.$v['tempMax'],
                        'icon' => Yii::$app->request->hostInfo.'/attachment/icon/'.$data2['daily'][$k]['textDay'].'.png',
                    );
                }
            }
            //设置缓存
            Yii::$app->cache->set($key,serialize($return),1800);
            //RedisString::set($key,serialize($return));
            //RedisString::expire($key, 1800);//设置缓存过期时间
        }

        return $return;

    }

    /**
     * @param null $region_id
     * @return array|string
     * User:五更的猫
     * DateTime:2021/9/28 13:46
     * TODO 获取客流数据
     */
    public static function getFlowData($region_id=null){

        $api = new JhApi();

        if($region_id=='all') {
            $list = $api->RealTimeScenicNum();
            $total_score = $api->ScenicTravelIndex();
        }else{
            $list = $api->RealTimeScenicNum($region_id);
            $total_score = $api->ScenicTravelIndex($region_id);
        }

        $jsonData = array(
            'new'=>0,  //实时人数
            'best'=>0, //最佳容量
            'max'=>0,  //最大容量
            'total_score'=>0,  //宜游指数
        );

        if(!is_array($list) || !is_array($total_score)){
            return $jsonData;
            //return $api->errmsg;
        }

        if(empty($list) || empty($total_score)){
            return $jsonData;
            //return Yii::t('app/api', '未找到此数据');
        }

        if($region_id=='all'){

            foreach ($list as $v){
                $jsonData['new'] += $v['tour_num'];
                $jsonData['best'] += (int)($v['day_capacity']*0.6);
                $jsonData['max'] += $v['day_capacity'];
            }
            foreach ($total_score as $v){
                $jsonData['total_score'] = $v['total_score'];
            }
        }else{
            $totalScore=0;
            foreach ($total_score as $v){
                if($v['scenic_id'] == $region_id){
                    $totalScore=$v['total_score'];
                }
            }

            $jsonData = array(
                'new'=>$list[0]['tour_num'],  //实时人数
                'best'=>(int)($list[0]['day_capacity']*0.6), //最佳容量
                'max'=>$list[0]['day_capacity'],  //最大容量
                'total_score'=>$totalScore,  //最大容量
            );
        }

        return $jsonData;
    }

    public static function getConfig($key,$lang=null){
        $lang = empty($lang)?CommonFunction::GetLang():$lang;
        switch ($lang){
            case 2:
                return Yii::$app->config->info($key.'_E');
                break;
            case 3:
                return Yii::$app->config->info($key.'_R');
                break;
            case 4:
                return Yii::$app->config->info($key.'_H');
                break;
            default:
                return Yii::$app->config->info($key);
                break;
        }
    }

    public static function http($url, $params, $method = 'GET', $header = array(), $timeout = 5)
    {
        // POST 提交方式的传入 $params 必须是字符串形式
        $opts = array(
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => $header
        );

        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET':
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                $params = http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            case 'DELETE':
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_HTTPHEADER] = array("X-HTTP-Method-Override: DELETE");
                $opts[CURLOPT_CUSTOMREQUEST] = 'DELETE';
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            case 'PUT':
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 0;
                $opts[CURLOPT_CUSTOMREQUEST] = 'PUT';
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }

        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        curl_setopt($ch, CURLOPT_ENCODING,'');

        $data = curl_exec($ch);
        $error = curl_error($ch);
        return $data;
    }

    public static function toUtf8($str) {
        $encode = mb_detect_encoding($str, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
        if ($encode == 'UTF-8') {
            return $str;
        } elseif ($encode == 'CP936') {
            return iconv('utf-8', 'latin1//IGNORE', $str);
        } else {
            return mb_convert_encoding($str, 'UTF-8', $encode);
        }

    }
}
