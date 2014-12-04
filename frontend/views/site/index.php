<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'My Blog';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
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
