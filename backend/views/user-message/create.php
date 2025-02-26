<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserMessage */

$this->title = 'Create User Message';
$this->params['breadcrumbs'][] = ['label' => 'User Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-message-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
