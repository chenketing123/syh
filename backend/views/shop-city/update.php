<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ShopCity */

$this->title = 'Update Shop City: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shop Cities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shop-city-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
