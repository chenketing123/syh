<?php
namespace backend\manager\config;

use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use Yii;
use yii\base\Exception;

/**
 * @Class ConfigAction
 * @package backend\api\config
 * @User:五更的猫
 * @DateTime: 2023/8/11 9:46
 * @TODO 配置的配置
 */
class ConfigAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        //分组
        $configGroupList = Yii::$app->params['configGroupList'];
        //类型
        $configTypeList = Yii::$app->params['configTypeList'];

        $jsonData['group'] = array();
        $jsonData['type'] = array();

        foreach ($configGroupList as $v){
            $jsonData['group'][]=array(
                'key'=>$v['id'],
                'value'=>$v['title'],
            );
        }

        foreach ($configTypeList as $v){
            $jsonData['type'][]=array(
                'key'=>$v['id'],
                'value'=>$v['title'],
            );
        }

        return $jsonData;
    }

}