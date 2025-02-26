<?php

namespace backend\manager\config;

use backend\models\Config;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use common\helper\redis\RedisString;
use Yii;
use yii\base\Exception;

/**
 * @Class EditAction
 * @package backend\api\config
 * @User:五更的猫
 * @DateTime: 2023/8/11 11:16
 * @TODO 修改配置
 */
class EditAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
        $config = $this->RequestData('config',array());
        /*array(
            array(
                'id'=>'配置ID',
                'value' => '配置值',
            )
        )*/
        $config = is_array($config)?$config:json_decode($config,true);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($config as $value)
            {
                $model = Config::find()->where(['id'=>$value['id']])->one();

                if($model)
                {
                    $model->value = (string)$value['value'];

                    if(!$model->save())
                    {
                        throw new Exception('修改失败');
                    }
                }
            }
            $transaction->commit();
            //清除缓存
            $key = Yii::$app->params['cacheName']['config'];
            //Yii::$app->cache->delete($key);
            RedisString::del($key);

        } catch (Exception $e) {
            $transaction->rollBack();

            throw new ApiException($e->getMessage(),1);
        }

        $jsonData['errmsg'] = 'ok';

        return $jsonData;
    }

}