<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Code */

$this->title = 'Create Code';
$this->params['breadcrumbs'][] = ['label' => 'Codes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
