<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user.nickname',
                'label' => '作者'
            ],
            'category.name',
            'title',
            'type',
            'status',
            'excerpt:ntext',
            'content:html',
            [
                'class' => DataColumn::className(),
                'attribute' => 'create_time',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'update_time',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            'top',
            'view',
            'sort',
            'slug',
            'password',
            'allow_comment',
            'comments_total',
        ],
    ]) ?>

</div>
