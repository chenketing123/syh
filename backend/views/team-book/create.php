<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TeamBook */

$this->title = 'Create Team Book';
$this->params['breadcrumbs'][] = ['label' => 'Team Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-book-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
