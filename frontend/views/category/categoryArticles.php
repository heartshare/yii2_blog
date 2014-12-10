<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = '文章列表 - ' . $curCategory['name'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="categoryArticles">
    <div class="list-group col-lg-8">
        <?php foreach ($categoryArticles['list'] as $article): ?>
            <div class="list-group-item">
                <h3>
                    <a href="<?= Url::toRoute(['article/view', 'id' => $article['id']]) ?>"><?= $article['title'] ?></a>
                </h3>

                <p class="excerpt">
                    <?= Html::encode($article['excerpt']) ?>
                </p>

                <div class="container-fluid row">
                    <span class="col-lg-5 col-xs-6">
                        <i class="glyphicon glyphicon-calendar"></i>
                        发布日期：<?= date('Y-m-d H:i:s', $article['create_time']) ?>
                    </span>
                    <span class="col-lg-3 col-xs-6">
                        <i class="glyphicon glyphicon-list"></i>
                        分类：<?= Html::a($article['category']['name'],
                            ['category/' . $article['category']['slug']]) ?>
                    </span>
                    <span class="col-lg-3 col-xs-8">
                        <i class="glyphicon glyphicon-user"></i>
                        作者：<?= $article['user']['nickname'] ?>
                    </span>
                    <span class="col-lg-1 col-xs-4">
                        <?= Html::a('阅读全文',
                            ['article/view', 'id' => $article['id']],
                            ['class' => 'btn btn-xs btn-default pull-right']) ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
        <?= LinkPager::widget([
            'pagination' => $categoryArticles['pages'],
        ]) ?>
    </div>
    <div class="sidebar col-lg-4">
        <div class="panel panel-default category-description">
            <div class="panel-heading">
                <i class="glyphicon glyphicon-book"></i>&nbsp;
                分类介绍
            </div>
            <div class="panel-body"><?= $curCategory['description'] ?></div>
        </div>

        <?= $this->render('//partial/_hotArticle',
            [
                'hotArticles' => $hotArticles
            ])
        ?>
    </div>
</div>