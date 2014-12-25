<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\assets\SimditorAsset;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\bootstrap\ActiveForm */
SimditorAsset::register($this);
$categoryList = ArrayHelper::map(\common\models\Category::find()->asArray()->all(),'id','name');
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'excerpt')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content')->textarea(['id'=>'editor']) ?>

    <?= $form->field($model, 'type')->dropDownList($model->getTypesOptions()) ?>

    <?= $form->field($model, 'status')->inline()->radioList($model->getStatusOptions()) ?>

    <?= $form->field($model, 'top')->inline()->radioList(['否','是']) ?>

    <?= $form->field($model, 'view')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'sort')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'allow_comment')->inline()->radioList(['否','是']) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryList) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
