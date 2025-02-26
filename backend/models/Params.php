<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%keywords}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $status
 * @property integer $sort
 * @property integer $append
 * @property integer $updated
 */
class Params extends \yii\db\ActiveRecord
{
   public static $status = [
       1=>'启用',
       2=>'禁用',
   ];

   public static $sex = [
       1=>'男',
       2=>'女'
   ];
    public static $sex2 = [
        0=>'未选择',
        1=>'男',
        2=>'女'
    ];
   public static $is = [
       1=>'是',
       2=>'否',
   ];

    public static $month = [
        1=>'一月',
        2=>'二月',
        3=>'三月',
        4=>'四月',
        5=>'五月',
        6=>'六月',
        7=>'七月',
        8=>'八月',
        9=>'九月',
        10=>'十月',
        11=>'十一月',
        12=>'十二月',
    ];

    public static $weeks = [
        0=>'周日',
        1=>'周一',
        2=>'周二',
        3=>'周三',
        4=>'周四',
        5=>'周五',
        6=>'周六',
    ];
    public static $day = [
        1=>'1',
        2=>'2',
        3=>'3',
        4=>'4',
        5=>'5',
        6=>'6',
        7=>'7',
        8=>'8',
        9=>'9',
        10=>'10',
        11=>'11',
        12=>'12',
        13=>'13',
        14=>'14',
        15=>'15',
        16=>'16',
        17=>'17',
        18=>'18',
        19=>'19',
        20=>'20',
        21=>'21',
        22=>'22',
        23=>'23',
        24=>'24',
        25=>'25',
        26=>'26',
        27=>'27',
        28=>'28',
        29=>'29',
        30=>'30',
        31=>'31',
    ];

    public static function SetList($data){
        $list = array();
        foreach ($data as $k=>$v){
            $list[]=array(
                'key'=>$k,
                'value'=>$v
            );
        }
        return $list;
    }

    public static function GetDefault($field,$data,$arr=array(),$default='-'){

        if(!empty($arr)){
            if(isset($data[$field]) && isset($arr[$data[$field]])){
                return $arr[$data[$field]];
            }else{
                return $default;
            }
        }else{
            return isset($data[$field])?$data[$field]:$default;
        }
    }

}
