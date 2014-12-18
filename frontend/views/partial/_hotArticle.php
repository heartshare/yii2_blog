<?php
use yii\helpers\Html;
?>
<div class="panel panel-default hot-article">
    <div class="panel-heading">
        <i class="glyphicon glyphicon-fire"></i>&nbsp;<?= Yii::t('app','Hot').Yii::t('app','Article') ?>
    </div>
    <ul class="list-group">
        <?php foreach ($hotArticles['list'] as $article): ?>
            <li class="list-group-item"><?= Html::a($article['title'],
                    ['article/view', 'id' => $article['id']]) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>