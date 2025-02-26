<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BookCategory */

$this->title = 'Create Book Category';
$this->params['breadcrumbs'][] = ['label' => 'Book Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
