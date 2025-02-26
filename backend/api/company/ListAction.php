<?php

namespace backend\api\company;
use backend\models\Company;
use backend\models\CompanyCategory;
use common\base\api\CommonApiAction;
use common\components\Helper;
use Yii;


class ListAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $search=$this->RequestData('search');
        $industry=$this->RequestData('industry');
        $begin=($page-1)*$page_number;
        $query=Company::find()->filterWhere(['like','title',$search]);
        if($industry){
            $arr=explode(',',$industry);
            foreach ($arr as $v){
                $query->andFilterWhere(['like','industry',$v]);
            }
        }
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('sort asc,id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        $category=CompanyCategory::find()->orderBy('sort asc, id desc')->all();
        $jsonData['category']=[];
        foreach ($model as $k=>$v){
            $v['industry']=explode(',',$v['industry']);
            $jsonData['list'][]=Helper::model_message($v);
        }

        foreach ($category as $k=>$v){
            $jsonData['category'][]=Helper::model_message($v);
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }

}