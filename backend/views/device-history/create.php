<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DeviceHistory */

$this->title = 'Create Device History';
$this->params['breadcrumbs'][] = ['label' => 'Device Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
