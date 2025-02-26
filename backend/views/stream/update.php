<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Stream */

$this->title = 'Update Stream: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Streams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stream-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
