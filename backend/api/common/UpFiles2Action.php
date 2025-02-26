<?php

namespace backend\api\common;
use common\base\api\ApiAction;
use common\components\CommonFunction;
use common\components\File;
use common\components\Helper;
use common\exception\ApiException;
use Yii;

/**
 * Class UpImageAction
 * @package backend\api\common
 * User:五更的猫
 * DateTime:2020/9/15 11:42
 * TODO 上传图片
 */
class UpFiles2Action extends ApiAction
{
    protected function runAction()
    {

        $file=$this->RequestData('file');
        $arr=explode(',',$file);
        if(count($arr)>1){
            $name=date('YmdHis').Helper::random(5).'.mp3';
            $outputFile = "$name"; // 输出文件名
            $inputFiles = [ // 输入文件数组
                'file1.mp3',
                'file2.mp3',
                'file3.mp3'
            ];

            mergeMP3Files($outputFile, $inputFiles);
        }else{
            $jsonData['url']= $file;
        }



        return $jsonData;
    }


    function mergeMP3Files($outputFile, array $inputFiles) {
        $mp3s = array();
        foreach ($inputFiles as $file) {
            $mp3s[] = file_get_contents($file);
        }
        $combinedMP3 = implode('', $mp3s);
        return file_put_contents($outputFile, $combinedMP3);
    }

}