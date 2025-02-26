<?php

namespace backend\api\common;
use common\base\api\ApiAction;
use common\components\CommonFunction;
use common\components\File;
use common\exception\ApiException;
use Yii;

/**
 * Class UpImageAction
 * @package backend\api\common
 * User:五更的猫
 * DateTime:2020/9/15 11:42
 * TODO 上传图片
 */
class UpFilesAction extends ApiAction
{
    protected function runAction()
    {

        if(!isset($_FILES['file'])){
            throw new ApiException('请上传数据', 1);
        }
        $data = File::UpOneFile($_FILES['file'],false);

        if($data['error']!=0){
            throw new ApiException($data['msg'],1);
        }
        $jsonData['name'] = $_FILES['file']['name'];
        $jsonData['url'] = $data['url'];
        $jsonData['url2'] = CommonFunction::setImg($data['url']);

        return $jsonData;
    }

}