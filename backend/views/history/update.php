<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\History */

$this->title = 'Update History: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="history-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
