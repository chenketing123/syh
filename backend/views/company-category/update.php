<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CompanyCategory */

$this->title = 'Update Company Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Company Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-category-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
