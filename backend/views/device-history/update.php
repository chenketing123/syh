<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DeviceHistory */

$this->title = 'Update Device History: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Device Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="device-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
