<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PracticeCategory */

$this->title = 'Create Practice Category';
$this->params['breadcrumbs'][] = ['label' => 'Practice Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="practice-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
