<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Book */

$this->title = 'Create Book';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
