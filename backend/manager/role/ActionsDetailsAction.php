<?php

namespace backend\manager\role;

use backend\models\Actions;
use backend\models\EmployeeRole;
use backend\models\ManagerRole;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\base\Exception;


/**
 * @Class ActionsDetailsAction
 * @package backend\api\employeeRole
 * @User:五更的猫
 * @DateTime: 2023/8/15 11:27
 * @TODO 操作授权详情
 */
class ActionsDetailsAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
        $role_id  = $this->RequestData('role_id',0);

        if(empty($role_id)){
            throw new ApiException('请选择角色',1);
        }
        $model = ManagerRole::find()->andWhere(['id'=>$role_id])->one();

        if (empty($model)) {
            throw new ApiException('不存在此角色',1);
        }
        //所有权限
        $auth   = Actions::find()
            ->with([
                'actionsRule' => function($query) {
                    $role_id  = $this->RequestData('role_id',0);
                    $query->andWhere("role_id = "."'".$role_id."'");
                },
            ])
            ->orderBy('sort asc')
            ->asArray()
            ->all();

        $auth = $this->items_merge($auth,'id',0,'pid');

        $jsonData['list'] = $auth;


        return $jsonData;
    }
    public function items_merge($items,$id="id",$pid = 0,$pidName='pid',$level=1)
    {
        $arr = array();
        foreach($items as $v)
        {
            if($v[$pidName] == $pid)
            {
                $v['title'] = $v['name'];
                $v['is_check'] = empty($v['actionsRule'])?false:true;
                $v['level']=$level;
                $v['list'] = $this->items_merge($items,$id,$v[$id],$pidName,$level+1);
                $v['is_list'] = empty($v['list'])?0:1;
                $arr[] = $v;
            }
        }
        return $arr;
    }
}