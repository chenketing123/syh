<?php
namespace backend\controllers;

use yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use common\components\ArrayArrange;
use common\components\CommonFunction;
use moonland\phpexcel\Excel;


/**
 * Class ArticleController
 * @package backend\controllers
 * 文章管理控制器
 */
class LanguageController extends MController
{
    /**
     * @return array
     *
     */
    public function actionLanguage(){       
        $language =  Yii::$app->request->get('language');
        if(isset($language)){
            Yii::$app->session['language']=$language;
        }


        //切换完语言哪来的返回到哪里
        $this->goBack(Yii::$app->request->headers['Referer']);
    }


    public function actionFrontendLanguage(){
        $language =  Yii::$app->request->get('language');
        if(isset($language)){
            Yii::$app->session['frontend-language']=$language;
        }


        //切换完语言哪来的返回到哪里
        $this->goBack(Yii::$app->request->headers['Referer']);
    }
    public function actionList(){       
        return $this->render('list', [

        ]);
    } 

    public function actionEdit()
    {
        $request        = Yii::$app->request;
        $type     = $request->get('type','');

        if($type == 'backend_chinese'){
            $file = Yii::getAlias('@common')."/messages/zh-CN/app.php";
        }
        if($type == 'backend_english'){
            $file = Yii::getAlias('@common')."/messages/en-US/app.php";
        }

        if($type == 'backend_yn'){
            $file = Yii::getAlias('@common')."/messages/yn-YN/app.php";
        }

        

        if(!$fp = @fopen($file,'r+')){
            $this->message("打开文件失败",$this->redirect(['index']),'error');
        }
        


        if (Yii::$app->request->post())
        {   
            $content     = $request->post('content','');

            flock($fp,LOCK_EX);
            fwrite($fp,$content);
            flock($fp,LOCK_UN);
            fclose($fp);
    

            
            return $this->redirect(['list']);
        
            
        }
        else
        {

            flock($fp,LOCK_EX);
            $str = @fread($fp,filesize($file));
            flock($fp,LOCK_UN);
            fclose($fp);
    

            return $this->render('edit', [
                'type'     => $type,
                'content'     => $str,
            ]);
        }
    }






}