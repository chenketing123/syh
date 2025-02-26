<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserCheck */

$this->title = 'Create User Check';
$this->params['breadcrumbs'][] = ['label' => 'User Checks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-check-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
