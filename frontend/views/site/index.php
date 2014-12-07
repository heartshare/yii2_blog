<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'My Blog';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>素年锦时</h1>

        <p class="lead">夫君子之行，静以修身，俭以养德。非淡泊无以明志，非宁静无以致远.</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::toRoute(['article/list']) ?>">查看博文列表</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <?php foreach($articles as $article): ?>
            <div class="col-md-4">
                <h3>
                    <a href="<?= Url::toRoute(['article/view', 'id' => $article['id']]) ?>"><?= Html::encode($article['title']) ?></a>
                </h3>

                <p><?= Html::encode($article['excerpt']) ?></p>

                <p>
                    <a class="btn btn-default" href="<?= Url::toRoute(['article/view', 'id' => $article['id']]) ?>">Read more... &raquo;</a>
                </p>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
