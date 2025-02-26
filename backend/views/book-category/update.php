<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookCategory */

$this->title = 'Update Book Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Book Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-category-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
