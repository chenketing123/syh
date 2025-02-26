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
use backend\models\UserRoom;
use backend\models\User;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class EmployeeRoomUserListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
        $room_id = $this->RequestData('room_id',0);
        $employee_id = $this->RequestData('employee_id',0);
  


        if($employee_id){
            $where = ['and'];
            if($keywords){
                $where[] = ['or',['like','u.id',$keywords],['like','u.name',$keywords],['like','u.nickname',$keywords],['like','u.phone',$keywords],['like','u.phone1',$keywords]];
            }
            $models = User::find()
                        ->alias('u')
                        ->join('INNER JOIN',UserRoom::tableName()." AS ur","ur.user_id = u.id and ur.room_id=".$room_id.' and ur.employee_id='.$employee_id)
                        ->where($where)->orderBy('u.id desc')->select('u.id, u.name, u.nickname,u.phone,u.phone1')->asArray()->all();

    
            $list = array();
            foreach ($models as $v){
                $list[] = [
                    'id' => $v['id'],
                    'text' => $v['id'].'_'.$v['nickname'].'_'.$v['name'].'_'.$v['phone'].'_'.$v['phone1']
                ];

            }
            $jsonData['list'] = $list;
        }else{
            $jsonData['list'] = array();

        }

 
 



        return $jsonData;



    }

}