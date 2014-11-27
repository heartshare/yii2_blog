<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\assets\SimditorAsset;
use yii\helpers\ArrayHelper;
use common\models\Role;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\bootstrap\ActiveForm */
SimditorAsset::register($this);
$roles = ArrayHelper::map(Role::find()->asArray()->all(),'id','name');
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                'offset' => 'col-sm-offset-3',
                'wrapper' => 'col-sm-9',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'nickname')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusOptions()) ?>

    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model,'gender')->inline()->radioList($model->getGenderOptions()) ?>

    <?= $form->field($model,'phone')->textInput() ?>

    <?= $form->field($model,'password')->textInput() ?>

    <?= $form->field($model,'avatar')->fileInput() ?>

    <?= $form->field($model,'profile')->textarea(['class'=>'editor']) ?>

    <?= $form->field($model,'site')->textInput() ?>

    <?= $form->field($model,'role_id')->dropDownList($roles) ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
