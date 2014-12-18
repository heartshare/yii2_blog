<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Article') . Yii::t('app', 'List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="article-list">
    <div class="col-lg-8 list-group article-list">
        <?php foreach ($newArticles['list'] as $article): ?>
            <div class="list-group-item" style="">
                <h3>
                    <a href="<?= Url::toRoute(['article/view', 'id' => $article['id']]) ?>"><?= $article['title'] ?></a>
                </h3>

                <p class="excerpt">
                    <?= Html::encode($article['excerpt']) ?>
                </p>

                <div class="container-fluid row">
                    <span class="col-lg-5 col-xs-6">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <?= Yii::t('app', 'Publish Time') ?>：<?= date('Y-m-d H:i:s', $article['create_time']) ?>
                    </span>
                    <span class="col-lg-3 col-xs-6">
                        <i class="glyphicon glyphicon-list"></i>
                        <?= Yii::t('app', 'Category') ?>：<?= Html::a($article['category']['name'],
                            ['category/' . $article['category']['slug']]) ?>
                    </span>
                    <span class="col-lg-3 col-xs-8">
                        <i class="glyphicon glyphicon-user"></i>
                        <?= Yii::t('app', 'Author') ?>：<?= $article['user']['nickname'] ?>
                    </span>
                    <span class="col-lg-1 col-xs-4">
                        <?= Html::a(Yii::t('app', 'Read more') . '&raquo;',
                            ['article/view', 'id' => $article['id']],
                            ['class' => 'btn btn-xs btn-default pull-right']) ?>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
        <?= LinkPager::widget([
            'pagination' => $newArticles['pages'],
        ]) ?>
    </div>
    <div class="col-lg-4 sidebar">
        <?= $this->render('//partial/_hotArticle',
            [
                'hotArticles' => $hotArticles
            ])
        ?>
    </div>
</div>