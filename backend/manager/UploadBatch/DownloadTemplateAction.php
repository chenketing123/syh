<?php

namespace backend\manager\UploadBatch;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UploadBatchSearch;
use yii\data\Pagination;
use backend\models\UploadBatch;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class DownloadTemplateAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $jsonData['list'][] = array(
            'title'=>'会员拉黑、会员恢复、客户交接批量操作导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/批量操作导入模板.xls"
        );
        $jsonData['list'][] = array(
            'title'=>'会员设置员工标签批量操作导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/会员设置员工标签批量操作导入模板.xls"
        );
        $jsonData['list'][] = array(
            'title'=>'设置市场归属批量操作导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/设置市场归属批量操作导入模板.xls"
        );
        /*$jsonData['list'][] = array(
            'title'=>'线下客户导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/线下客户导入模板.xls"
        );*/
        $jsonData['list'][] = array(
            'title'=>'批量修改手机号导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/批量修改手机号导入模板.xls"
        );
        $jsonData['list'][] = array(
            'title'=>'统计表期初数据导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/统计表期初数据导入模板.xls"
        );
        $jsonData['list'][] = array(
            'title'=>'批量删除操作导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/批量删除操作导入模板.xls"
        );
        /*$jsonData['list'][] = array(
            'title'=>'旅游名单报名记录导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/旅游名单报名记录导入模板.xls"
        );*/
        $jsonData['list'][] = array(
            'title'=>'期初额度导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/期初额度导入模板.xls"
        );
        $jsonData['list'][] = array(
            'title'=>'员工导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/员工导入模板.xls"
        );
        $jsonData['list'][] = array(
            'title'=>'架构导入模板',
            'url'=>Yii::$app->request->hostInfo.Yii::getAlias('@static')."/excel/架构导入模板.xls"
        );

        return $jsonData;
    }

}