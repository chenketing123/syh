<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PracticeUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Practice Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="practice-user-view">

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
            'practice_id',
            'user_id',
            'file',
            'image',
            'content',
            'created_at',
            'updated_at',
            'file_time',
        ],
    ]) ?>

</div>
