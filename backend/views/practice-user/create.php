<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PracticeUser */

$this->title = 'Create Practice User';
$this->params['breadcrumbs'][] = ['label' => 'Practice Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="practice-user-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
