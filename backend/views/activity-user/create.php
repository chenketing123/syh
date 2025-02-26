<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ActivityUser */

$this->title = 'Create Activity User';
$this->params['breadcrumbs'][] = ['label' => 'Activity Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-user-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
