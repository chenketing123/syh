<?php

namespace backend\manager\role;

use backend\models\Actions;
use backend\models\EmployeeMenu;
use backend\models\EmployeeRole;
use backend\models\ManagerRole;
use backend\models\Params;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use Yii;
use yii\data\Pagination;


/**
 * @Class ListAction
 * @package backend\api\employeeMenu
 * @User:五更的猫
 * @DateTime: 2023/8/14 18:08
 * @TODO 菜单列表
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $models = ManagerRole::find()->orderBy('id desc')->all();

        $list = array();
        $is = Params::$is;
        foreach ($models as $v){
            $list[]=array(
                'id' => $v['id'],
                'name' => $v['name'],
                'date' => date('Y-m-d H:i:s',$v['append']),
            );
        }

        $jsonData['list'] = $list;

        return $jsonData;
    }
}