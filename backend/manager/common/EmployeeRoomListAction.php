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
use backend\models\LiveRoom;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class EmployeeRoomListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
        $employee_id = $this->RequestData('employee_id',0);
  


        if($employee_id){
            $where = ['and'];
            if($keywords){
                $where[] = ['like','lr.title',$keywords];
            }
            $models = LiveRoom::find()
                        ->alias('lr')
                        ->join('INNER JOIN',EmployeeRoom::tableName()." AS er","er.room_id = lr.id and er.employee_id=".$employee_id)
                        ->where($where)->orderBy('lr.id desc')->select('lr.id, lr.title')->asArray()->all();
 


    
            $list = array();
            foreach ($models as $v){
                $list[] = [
                    'id' => $v['id'],
                    'title' => $v['title'],
                ];
            }
            $jsonData['list'] = $list;
        }else{
            $jsonData['list'] = array();

        }

 
 



        return $jsonData;



    }

}