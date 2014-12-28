<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$replyLink = Yii::$app->urlManager->createAbsoluteUrl(['article/' . $article['id']]);
?>

    Hello <?= Html::encode($replyToUserInfo->nickname) ?>,

    您在<?= Html::a(Yii::$app->params['sitename'], Yii::$app->urlManager->createAbsoluteUrl('site/index')) ?>的评论有了
<?= $replyByUserInfo->nickname ?>的新回复，可<?= Html::a('点我查看详情', $replyLink) ?>。

    <br/>

<?= Html::encode($content) ?>