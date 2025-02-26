<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PracticeCategory */

$this->title = 'Update Practice Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Practice Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="practice-category-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
