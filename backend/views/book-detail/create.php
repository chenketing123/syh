<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BookDetail */

$this->title = 'Create Book Detail';
$this->params['breadcrumbs'][] = ['label' => 'Book Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-detail-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
