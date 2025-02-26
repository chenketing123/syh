<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Mark */

$this->title = 'Update Mark: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Marks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mark-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
