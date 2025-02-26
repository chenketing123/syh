<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BookDetail */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Book Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-detail-view">

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
            'book_id',
            'parent_id',
            'title',
            'sort',
            'level',
            'number1',
            'number2',
            'content:ntext',
            'day',
        ],
    ]) ?>

</div>
