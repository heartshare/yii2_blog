<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'User',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'nickname',
            'email:email',
            'gender',
            // 'phone',
            // 'password_hash',
            // 'profile',
            // 'avatar',
            // 'create_time',
            // 'update_time',
            // 'active_time',
            // 'status',
            // 'auth_key',
            // 'password_reset_token',
            // 'site',
            // 'role_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
