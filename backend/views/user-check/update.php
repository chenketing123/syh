<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserCheck */

$this->title = 'Update User Check: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Checks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-check-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
