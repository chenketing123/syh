<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Code */

$this->title = 'Update Code: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="code-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
