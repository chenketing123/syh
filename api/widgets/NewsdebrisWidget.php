<?php
/**
 * Created by PhpStorm.
 * User: zjb05
 * Date: 2017/5/31
 * Time: 11:52
 */

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use backend\models\Article;

class NewsdebrisWidget extends Widget
{

    public $cate_stair;
    public $cate_second;
    public $cate_third;
    public $cate_fourth;
    public $area_id;
    public $limit;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        //区域
        if(Yii::$app->session->get('area')){
            $area = Yii::$app->session->get('area');
            $this->area_id = $area['id'];
        }else{
            $this->area_id = 1;
        }
    }

    public function run()
    {
        $models = Article::find()
            ->andFilterWhere(['cate_stair'=>$this->cate_stair])
            ->andFilterWhere(['cate_second'=>$this->cate_second])
            ->andFilterWhere(['cate_third'=>$this->cate_third])
            ->andFilterWhere(['cate_fourth'=>$this->cate_fourth])
            ->andWhere(['display'=>1, 'status'=>1])
            ->andWhere(['area_id'=>$this->area_id])
            ->orderBy('sort asc, append desc')
            ->limit($this->limit)
            ->all();

        return $this->render('newsdebris/index',[
            'models' => $models
        ]);
    }


}