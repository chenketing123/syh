<?php

namespace backend\api\common;
use backend\models\Provinces;
use common\base\api\ApiAction;
use Yii;

class City2Action extends ApiAction
{
    protected function runAction()
    {
        $province_id=$this->RequestData('province_id');
        $ids=explode(',',$province_id);
        $jsonData['list']=[];
        if($province_id){
            $model=Provinces::find()->where(['in','parentid',$ids])->all();
            foreach ($model as $k=>$v){
                $jsonData['list'][]=[
                    'id'=>$v['id'],
                    'province'=>Provinces::getName2($v['parentid']),
                    'value'=>$v['areaname'],
                ];
            }
        }

        return $jsonData;
    }

}