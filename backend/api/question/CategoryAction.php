<?php

namespace backend\api\question;
use backend\models\QuestionCategory;
use common\base\api\CommonApiAction;
use Yii;


class CategoryAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $model=QuestionCategory::find()->orderBy('sort asc,id desc')->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'title'=>$v['title'],

            ];
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }

}