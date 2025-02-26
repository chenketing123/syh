<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TeamBook */

$this->title = 'Update Team Book: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Team Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="team-book-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
