<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookDetail */

$this->title = 'Update Book Detail: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Book Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-detail-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
