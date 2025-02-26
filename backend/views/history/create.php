<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\History */

$this->title = 'Create History';
$this->params['breadcrumbs'][] = ['label' => 'Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="history-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
