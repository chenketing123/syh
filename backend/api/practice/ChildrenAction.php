<?php

namespace backend\api\practice;
use backend\models\PracticeCategory;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;


class ChildrenAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $id=$this->RequestData('id');
        $model=PracticeCategory::find()->where(['parent_id'=>$id])->orderBy('sort asc,id desc')->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'image'=>CommonFunction::setImg($v['image']),
                'title'=>$v['title'],
            ];
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }

}