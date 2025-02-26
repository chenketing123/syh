<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookCollect */

$this->title = 'Update Book Collect: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Book Collects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-collect-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
