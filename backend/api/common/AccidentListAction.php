<?php

namespace backend\api\common;
use backend\models\Accident;
use backend\models\Car;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;

/**
 * Class UpImageAction
 * @package backend\api\common
 * User:五更的猫
 * DateTime:2020/9/15 11:42
 * TODO 上传图片
 */
class AccidentListAction extends ManagerApiAction
{

    public $isSign = true;
    public $isLogin = true;
    protected function runAction()
    {


        $user_id=Yii::$app->request->post('user_id');
        $direction=Yii::$app->request->post('direction');
        $page=$this->RequestData('page',1);
        $page_number=$this->RequestData('page_number',10);
        $location=$this->RequestData('location');
        $type=Yii::$app->request->post('type');
        $road=Yii::$app->request->post('road');
        $begin=($page-1)*$page_number;
        $query=Accident::find()->filterWhere(['user_id'=>$user_id])->andFilterWhere(['like','direction',$direction])
            ->andFilterWhere(['like','direction',$direction])  ->andFilterWhere(['like','location',$location])
            ->andFilterWhere(['type'=>$type])  ->andFilterWhere(['road'=>$road]);
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            if($v['image']){
                $arr_image=explode(',',$v['image']);
                $arr_image_value=[];
                foreach ($arr_image as $k2=>$v2){
                    $arr_image_value[]=CommonFunction::setImg($v2);
                }
                $v['image']=implode(',',$arr_image_value);
            }
            if($v['occupy']){
                $arr_occ=explode(',',$v['occupy']);
                $arr_value=[];
                foreach ($arr_occ as $k2=>$v2){
                    if($v2==0){
                        $arr_value[]='应急车道';
                    }else{
                        $arr_value[]=$v2;
                    }
                }
                $v['occupy']=implode(',',$arr_value);
            }
            $jsonData['list'][]=Helper::model_message($v);
        }
        $jsonData['errmsg']='';
        return $jsonData;


    }

}