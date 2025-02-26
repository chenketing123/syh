<?php

namespace backend\api\common;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\File;
use common\components\Helper;
use Yii;


class UpFiles3Action extends CommonApiAction
{
    protected function runAction()
    {

        $file=$this->RequestData('file');
        $arr=explode(',',$file);
        if(count($arr)<=1){
            $jsonData['url']=CommonFunction::unsetImg($file);
            $jsonData['url2']=$file;
            $jsonData['name']='test';

        }else{
            $value_arr=[];
            foreach ($arr as $k=>$v){
                $message=CommonFunction::unsetImg($v);
                $value_arr[]=Yii::getAlias('@webPath').$message;
            }
            $name=date('His').Helper::random(4);
            $file = fopen(Yii::getAlias('@webPath').'/uploads/'.$name.'.mp3', 'wb');
            $jsonData['url2']=Yii::$app->request->hostInfo.'/uploads/'.$name.'.mp3';
            $jsonData['url']='/uploads/'.$name.'.mp3';
            $jsonData['name']=$name.'.mp3';
            foreach ($value_arr as $k=>$v){
                $cacheFileName = $v;
                $cacheFile     = fopen($cacheFileName, 'rb');
                $content       = fread($cacheFile, filesize($cacheFileName));
                fwrite($file, $content);
                fclose($cacheFile);
//                unlink($cacheFileName);
            }

            fclose($file);
        }
        return $jsonData;
    }

}