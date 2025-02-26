<?php

namespace backend\manager\common;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\DownloadSearch;
use yii\data\Pagination;
use backend\models\Employee;
use backend\models\EmployeeRoom;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class RoomEmployeeListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
        $room_id = $this->RequestData('room_id',0);
  


        if($room_id){
            $where = ['and'];
            if($keywords){
                $where[] = ['like','e.name',$keywords];
            }
            $models = Employee::find()->alias('e')->join('INNER JOIN', EmployeeRoom::tableName() . " AS er", "er.employee_id = e.id and er.room_id=".$room_id)->where($where)->orderBy('is_leader asc,id desc')->all();

            $list = array();
            foreach ($models as $v){
                $list[] = [
                    'id' => (int)$v['id'],
                    'name' => $v['name'],
                ];
         
            }
            $jsonData['list'] = $list;
        }else{
            $jsonData['list'] = array();

        }

 
 



        return $jsonData;



    }

}