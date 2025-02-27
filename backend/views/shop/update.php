<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Shop */

$this->title = 'Update Shop: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shop-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
