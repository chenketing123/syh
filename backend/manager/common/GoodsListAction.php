<?php

namespace backend\manager\common;

use backend\models\JxcGoods;
use backend\models\JxcGoodsCategory;
use common\base\api\ManagerApiAction;


/**
 * @Class GoodsListAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/12/12 16:58
 * @TODO 进销存商品列表
 */
class GoodsListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
 

        $where = ['and'];
        if($keywords){
            $column = JxcGoodsCategory::find()->andWhere(['like','title',$keywords])->column();
            $where[] = ['or',['like','title',$keywords],['in','category_id',$column]];
        }
        $list = JxcGoods::find()->select('id,title,category_id')->where($where)->orderBy('sort asc,id desc')->asArray()->all();
        $typeArr = JxcGoodsCategory::getList();

        foreach ($list as $k => $v){
            $list[$k]['title_full'] = $typeArr[$v['category_id']].'_'.$v['title'];
        }

        $jsonData['list'] = $list;

        return $jsonData;



    }

}