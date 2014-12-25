<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = $article['title'];
$this->params['breadcrumbs'][] = ['label' => $article['category']['name'], 'url' => ['/category/' . $article['category']['slug']]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3><?= Html::encode($article['title']) ?></h3>

<div id="article-info" class="row">
    <div class="col-lg-3 col-sm-6">
        <i class="glyphicon glyphicon-calendar"></i>&nbsp;
        <?= Yii::t('app', 'Posted {time}', ['time' => date('Y-m-d H:i:s', $article['create_at'])]) ?>
    </div>
    <div class="col-lg-3 col-sm-6">
        <i class="glyphicon glyphicon-list"></i>&nbsp;
        <?= Yii::t('app', 'Category') ?>
        ：<?= Html::a($article['category']['name'], Url::toRoute(['/category/' . $article['category']['slug']])) ?>
    </div>
    <div class="col-lg-3 col-sm-6">
        <i class="glyphicon glyphicon-eye-open"></i>&nbsp;
        <?= Yii::t('app', 'Views {total}', ['total' => $article['view']]) ?>
    </div>
    <div class="col-lg-3 col-sm-6">
        <i class="glyphicon glyphicon-comment"></i>&nbsp;
        <?php if ($article['comments_total'] > 0): ?>
            <?= Yii::t('app', 'Comments {total}', ['total' => $article['comments_total']]) ?>
        <?php else: ?>
            <?= Yii::t('app', 'No Comments') ?>
        <?php endif; ?>
    </div>
</div>

<hr/>

<div id="article-content"><?= $article['content'] ?></div>