<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserIcon */

$this->title = 'Update User Icon: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'User Icons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-icon-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
