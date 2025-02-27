<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityUser */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Activity Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'activity_id',
            'mobile',
            'name',
            'status',
            'created_at',
            'updated_at',
            'price',
            'paid_time',
            'order_number',
        ],
    ]) ?>

</div>
