<?php

namespace backend\api\common;

use backend\models\Params;
use backend\models\Provinces;
use common\base\api\ApiAction;
use Yii;

class Address2Action extends ApiAction
{
    protected function runAction()
    {

        $jsonData['list']=[];
        $model=Provinces::find()->where(['parentid'=>0])->all();
        foreach ($model as $k=>$v){
            $children=Provinces::find()->where(['parentid'=>$v['id']])->all();
            $list2=[];
            foreach ($children as $k2=>$v2){
                $list3=[];
                $children2=Provinces::find()->where(['parentid'=>$v2['id']])->all();
                foreach ($children2 as $k3=>$v3){
                    $list3[]=[
                        'id'=>$v3['id'],
                        'name'=>$v3['areaname'],
                    ];
                }
                $list2[]=[
                    'id'=>$v2['id'],
                    'name'=>$v2['areaname'],
                    'children'=>$list3
                ];
            }
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'name'=>$v['areaname'],
                'children'=>$list2
            ];
        }

        return $jsonData;
    }

}