<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserTeam */

$this->title = 'Create User Team';
$this->params['breadcrumbs'][] = ['label' => 'User Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-team-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
