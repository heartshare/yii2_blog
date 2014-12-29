<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArticleCommentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Article Comments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-comments-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Article Comments',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nickname',
            [
                'label' => '所评论文章标题',
                'attribute' => 'article.title'
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'create_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            'content:html',
//            'ip',
//            'agent',
            // 'reply_to',
            // 'parent_id',
             'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
