<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PracticeUser */

$this->title = 'Update Practice User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Practice Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="practice-user-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
