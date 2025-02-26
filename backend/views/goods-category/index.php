<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\GoodsCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Goods Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code_id',
            'title',
            'parent_id',
            'level',
            // 'sort',
            // 'created_at',
            // 'updated_at',
            // 'image',
            // 'is_show',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
