<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BookCollect */

$this->title = 'Create Book Collect';
$this->params['breadcrumbs'][] = ['label' => 'Book Collects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-collect-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
