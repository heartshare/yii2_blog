<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ArticleComments */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Article Comments',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Article Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-comments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
