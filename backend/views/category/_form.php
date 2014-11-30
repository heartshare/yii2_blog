<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
$parentCategory = ArrayHelper::map($model::findAll(['parent_id' => 0]), 'id', 'category_name');
$parentCategory = ArrayHelper::merge(['顶级分类'], $parentCategory);
unset($parentCategory[$model->id]);
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'sort')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'parent_id')->dropDownList($parentCategory) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
