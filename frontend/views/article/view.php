<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\assets\SimditorAsset;
use yii\captcha\Captcha;

/* @var $this yii\web\View */

$this->title = $article['title'];
$this->params['breadcrumbs'][] = ['label' => $article['category']['name'], 'url' => ['/category/' . $article['category']['slug']]];
$this->params['breadcrumbs'][] = $this->title;
SimditorAsset::register($this);

$form = ActiveForm::begin([
    'layout' => 'horizontal',
    'action' => ['comment'],
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-2',
            'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-10',
            'error' => '',
            'hint' => '',
        ],
    ],
]);

$this->registerJs('$("#insert-comment").click(function(){
            if($.trim($("#editor").val()) == ""){
                alert("您不说点什么就想提交么？");
                return false;
            }
        })');
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
            <?php if ($articleCommentsTotal > 0): ?>
                <?= Yii::t('app', 'Comments {total}', ['total' => $articleCommentsTotal]) ?>
            <?php else: ?>
                <?= Yii::t('app', 'No Comments') ?>
            <?php endif; ?>
        </div>
    </div>

    <hr/>

    <div id="article-content"><?= $article['content'] ?></div>

    <hr/>

<?= $form->field($articleCommentFormModel, 'nickname')->textInput() ?>

<?= $form->field($articleCommentFormModel, 'email')->textInput() ?>

<?= $form->field($articleCommentFormModel, 'site')->textInput() ?>

<?= $form->field($articleCommentFormModel, 'content')->textarea(['id' => 'editor', 'placeholder' => '人可以走，把话留下']) ?>

<?= $form->field($articleCommentFormModel, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
]) ?>

<?= $form->field($articleCommentFormModel, 'article_id', ['template' => '{input}'])->hiddenInput(['value' => $article['id']]) ?>

<?= $form->field($articleCommentFormModel, 'parent_id', ['template' => '{input}'])->hiddenInput(['value' => 0]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'id' => 'insert-comment']) ?>
        </div>
    </div>

<?php $form->end(); ?>