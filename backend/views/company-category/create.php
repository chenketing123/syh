<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CompanyCategory */

$this->title = 'Create Company Category';
$this->params['breadcrumbs'][] = ['label' => 'Company Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-category-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
