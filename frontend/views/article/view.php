<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = $article['title'];
$this->params['breadcrumbs'][] = ['label' => $article['category']['category_name'], 'url' => ['/category/' . $article['category']['slug']]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3><?= Html::encode($article['title']) ?></h3>

<div id="article-info" class="row">
    <div class="col-lg-3 col-sm-6">
        <i class="glyphicon glyphicon-calendar"></i>&nbsp;
        发布于公元<?= date('Y-m-d H:i:s', $article['create_time']) ?>
    </div>
    <div class="col-lg-3 col-sm-6">
        <i class="glyphicon glyphicon-list"></i>&nbsp;
        所属分类：<?= Html::a($article['category']['category_name'], Url::toRoute(['/category/' . $article['category']['slug']])) ?>
    </div>
    <div class="col-lg-3 col-sm-6">
        <i class="glyphicon glyphicon-eye-open"></i>&nbsp;
        看热闹打酱油的有<?= $article['view'] ?>人
    </div>
    <div class="col-lg-3 col-sm-6">
        <i class="glyphicon glyphicon-comment"></i>&nbsp;
        <?php if($article['comments_total'] > 0): ?>
            已有<?= $article['comments_total'] ?>人发表读后感
        <?php else: ?>
            还没人鸟我哟o(╯□╰)o
        <?php endif; ?>
    </div>
</div>

<hr/>

<div id="article-content"><?= $article['content'] ?></div>