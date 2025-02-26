<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserTeam */

$this->title = 'Update User Team: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'User Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-team-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
