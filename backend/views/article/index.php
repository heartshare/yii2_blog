<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
            'modelClass' => 'Article',
        ]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category.name',
            [
                'attribute' => 'user.nickname',
                'label' => '作者'
            ],
            'title',
//            'content:ntext',
            [
                'class' => DataColumn::className(),
                'attribute' => 'create_time',
                'format' => ['date', 'php:Y-m-d'],
                'label' => '创建时间'
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'update_time',
                'format' => ['date', 'php:Y-m-d'],
                'label' => '更新时间'
            ],
            // 'type',
            // 'status',
            // 'top',
            // 'view',
            // 'sort',
            // 'slug',
            // 'excerpt:ntext',
            // 'password',
            // 'allow_comment',
            // 'comments_total',
            // 'user_id',
            // 'category_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
