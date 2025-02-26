<?php

namespace backend\api\practice;
use backend\models\PracticeCategory;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;


class CategoryAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $model=PracticeCategory::find()->where(['parent_id'=>0])->orderBy('sort asc,id desc')->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            $children=PracticeCategory::find()->where(['parent_id'=>$v['id']])->count()*1;
            if($children>0){
                $type=2;
            }else{
                $type=1;
            }

            $jsonData['list'][]=[
                'id'=>$v['id'],
                'image'=>CommonFunction::setImg($v['image']),
                'type'=>$type,
                'title'=>$v['title'],
            ];
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }

}