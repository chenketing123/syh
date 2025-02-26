<?php

namespace backend\manager\common;

use backend\models\ActivityApply;
use backend\models\Download;
use backend\models\JxcGoods;
use backend\models\JxcGoodsCategory;
use backend\models\Params;
use backend\models\UploadBatch;
use common\base\api\ManagerApiAction;


/**
 * @Class GoodsListAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/12/12 16:58
 * @TODO 进销存商品列表
 */
class ConfigAction extends ManagerApiAction
{
    protected function runAction()
    {
        $type1 = array(0=>'全部')+UploadBatch::$type;

        $jsonData['type1'] = Params::SetList($type1);

        $type2 = array(0=>'全部')+Download::$type;

        $jsonData['type2'] = Params::SetList($type2);


        $type3 = ActivityApply::$wuxiao;

        $jsonData['type3'] = Params::SetList($type3);

        return $jsonData;



    }

}