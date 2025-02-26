<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\question */

$this->title = 'Update Question: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="question-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
