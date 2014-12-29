<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleComments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-comments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'create_at')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'agent')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'parent_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'article_id')->textInput(['maxlength' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
