<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TaskUser */

$this->title = 'Create Task User';
$this->params['breadcrumbs'][] = ['label' => 'Task Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-user-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
