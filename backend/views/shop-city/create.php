<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ShopCity */

$this->title = 'Create Shop City';
$this->params['breadcrumbs'][] = ['label' => 'Shop Cities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-city-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
