<?php

namespace backend\manager\common;

use backend\models\ManagerMenu;
use backend\models\ManagerMenuRule;
use common\base\api\ManagerApiAction;
use common\components\ArrayArrange;
use Yii;

/**
 * @Class EmployeeMenuAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2024/1/8 11:27
 * @TODO 菜单权限
 */
class EmployeeMenuAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
        if($this->user->id==Yii::$app->params['adminAccount']){
            $models = ManagerMenu::find()->andWhere(['status'=>1])->orderBy('sort Asc,append Asc')->asArray()->all();
        }else{
            $ids = ManagerMenuRule::find()->andWhere(['role_id'=>$this->user->role_id])->select('menu_id')->column();
            if(empty($ids)){
                $ids = array('-1');
            }
            $models = ManagerMenu::find()->andWhere(['in','id',$ids])->andWhere(['status'=>1])->orderBy('sort Asc,append Asc')->asArray()->all();
        }

        $models = ArrayArrange::items_merge($models,'id');

        $list = array();

        foreach ($models as $k=>$v){
            $info = array(
                'name'=>$v['name'],
                'path'=>$v['url'],
                'component'=>$v['component'],
                'meta'=>array(
                    'icon'=>$v['menu_css'],
                    'title'=>$v['title'],
                    'role'=>[$this->user->getRoleName()],
                ),
                'isShow'=>$k==0?true:false,//是否被选中
                'isHas'=>false,//是否有子列表
                'children'=>$this->SetList($v['-']),
            );

            if(!empty($info['children'])){
                $info['isHas'] = true;
            }

            $list[]=$info;
        }

        $jsonData['list'] = $list;

        return $jsonData;
    }

    public function SetList($models){
        $info = array();
        if(!empty($models)){
            foreach ($models as $v){
                $children = array(
                    'name'=>$v['name'],
                    'path'=>$v['url'],
                    'component'=>$v['component'],
                    'meta'=>array(
                        'icon'=>$v['menu_css'],
                        'title'=>$v['title'],
                        'role'=>[$this->user->getRoleName()],
                    ),
                    'isShow'=>false,//是否被选中
                    'isHas'=>false,//是否有子列表
                    'children'=>$this->SetList($v['-']),
                );
                if(!empty($children['children'])){
                    $children['isHas'] = true;
                }

                $info[]=$children;
            }
        }
        return $info;
    }

}