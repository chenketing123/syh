<?php

namespace backend\api\book;
use backend\models\Book;
use backend\models\BookCategory;
use backend\models\SetImage;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use Yii;


class List2Action extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $search=$this->RequestData('search');
        $begin=($page-1)*$page_number;
        $query=Book::find()->filterWhere(['like','title',$search]);
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('sort asc,id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            $v->info=Helper::truncate_utf8_string($v->info,500);
            $jsonData['list'][]=Helper::model_message($v);
        }


        $banner=SetImage::getList(['type'=>5]);
        $jsonData['banner']=[];
        foreach ($banner as $k=>$v){
            $jsonData['banner'][]=[
                'image'=>CommonFunction::setImg($v['image'])
            ];
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }

}