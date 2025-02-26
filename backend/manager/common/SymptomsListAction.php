<?php

namespace backend\manager\common;

use backend\models\JxcDiseases;
use backend\models\JxcDiseasesCategory;
use common\base\api\ManagerApiAction;



/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class SymptomsListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');


        $where = ['and'];
        if($keywords){
            $column = JxcDiseasesCategory::find()->andWhere(['like','title',$keywords])->column();
            $where[] = ['or',['like','title',$keywords],['in','category_id',$column]];
        }
        $where[] = ['type'=>2];
        $list = JxcDiseases::find()->select('id,title,category_id')->where($where)->orderBy('sort asc,id desc')->asArray()->all();
        $typeArr = JxcDiseasesCategory::getList();

        foreach ($list as $k => $v){
            if(!isset($typeArr[$v['category_id']])){
                $typeArr[$v['category_id']] = '未知分类';
            }
            $list[$k]['title_full'] = $typeArr[$v['category_id']].'_'.$v['title'];
        }

        $jsonData['list'] = $list;
        $jsonData['where'] = $where;


        return $jsonData;



    }

}