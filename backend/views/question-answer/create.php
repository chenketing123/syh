<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\QuestionAnswer */

$this->title = 'Create Question Answer';
$this->params['breadcrumbs'][] = ['label' => 'Question Answers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-answer-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
