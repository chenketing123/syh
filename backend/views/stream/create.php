<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Stream */

$this->title = 'Create Stream';
$this->params['breadcrumbs'][] = ['label' => 'Streams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stream-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
