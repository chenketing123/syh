<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Practice */

$this->title = 'Create Practice';
$this->params['breadcrumbs'][] = ['label' => 'Practices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="practice-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
