<?php
namespace backend\manager\role;

use backend\models\Actions;
use backend\models\EmployeeMenu;
use backend\models\EmployeeRole;
use backend\models\ManagerRole;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\base\Exception;

/**
 * @Class DelAction
 * @package backend\api\employeeRole
 * @User:五更的猫
 * @DateTime: 2023/8/15 10:41
 * @TODO 删除角色
 */
class DelAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
        $id = $this->RequestData('id',0);

        if (empty($id)) {
            throw new ApiException('请选择角色',1);
        }

        $model = ManagerRole::find()->andWhere(['id'=>$id])->one();

        if (empty($model)) {
            throw new ApiException('不存在此角色',1);
        }

        if(!$model->delete()){
            throw new Exception('删除角色：'.$model['name'].'失败',1);
        }

        $jsonData['id'] = $id;

        return $jsonData;
    }

}