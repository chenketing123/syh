<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\QuestionCategory */

$this->title = 'Create Question Category';
$this->params['breadcrumbs'][] = ['label' => 'Question Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
