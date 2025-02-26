<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Practice */

$this->title = 'Update Practice: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Practices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="practice-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
