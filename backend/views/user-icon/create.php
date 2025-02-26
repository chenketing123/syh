<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserIcon */

$this->title = 'Create User Icon';
$this->params['breadcrumbs'][] = ['label' => 'User Icons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-icon-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
