<?php

namespace backend\manager\config;

use backend\models\Config;
use backend\models\Params;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use Yii;
use yii\data\Pagination;


/**
 * @Class ListAction
 * @package backend\api\config
 * @User:五更的猫
 * @DateTime: 2023/8/11 11:05
 * @TODO 网站设置列表
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
        //分组
        $configGroupList = Yii::$app->params['configGroupList'];

        $models = array();

        foreach ($configGroupList as $v){
            $list = array();

            $model = Config::find()->andWhere(['group'=>$v['id']])->orderBy('sort asc,id desc')->all();

            foreach ($model as $v2){
                if(empty($v2['extra'])) {
                    $option = array();
                }else{
                    $option = Params::SetList(Config::parseConfigAttr($v2['extra']));
                }

                $list[]=array(
                    'id'        => $v2['id'],
                    'name'      => $v2['name'],
                    'type'      => $v2['type'],
                    'title'     => $v2['title'],
                    'group'     => $v2['group'],
                    'option'    => $option,
                    'remark'    => $v2['remark'],
                    'value'     => $v2['value'],
                );
            }

            $models[]=array(
                'key'=>$v['id'],
                'value'=>$v['title'],
                'list'=>$list
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}