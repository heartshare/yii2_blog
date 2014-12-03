<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = $article['title'];
$this->params['breadcrumbs'][] = ['label' => $article['category']['category_name'], 'url' => ['/category/' . $article['category']['slug']]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3><?= Html::encode($article['title']) ?></h3>

<div id="info" class="row">
    <div class="col-lg-4 col-sm-6">
        <i class="glyphicon glyphicon-calendar"></i>&nbsp;
        由<?= $article['user']['nickname'] ?>发布于：
        <?= date('Y-m-d H:i:s', $article['create_time']) ?>
    </div>
    <div class="col-lg-4 col-sm-6">
        <i class="glyphicon glyphicon-list"></i>&nbsp;
        <?= Html::a($article['category']['category_name'], Url::toRoute(['/category/' . $article['category']['slug']])) ?>
    </div>
    <div class="col-lg-2 col-xs-6">
        <i class="glyphicon glyphicon-eye-open"></i>&nbsp;
        热度：<?= $article['view'] ?>°
    </div>
    <div class="col-lg-2 col-xs-6">
        <i class="glyphicon glyphicon-comment"></i>&nbsp;
        已有<?= $article['comments_total'] ?>人发表读后感
    </div>
</div>

<hr/>

<div id="article-content"><?= $article['content'] ?></div>