<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\QuestionAnswer */

$this->title = 'Update Question Answer: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Question Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="question-answer-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
