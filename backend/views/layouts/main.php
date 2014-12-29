<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = [
        'label' => 'Article',
        'url' => ['/article/index']
    ];
    $menuItems[] = [
        'label' => Yii::t('app', 'Comments'),
        'url' => ['/article-comments/index'],
        'items' => [
            [
                'label' => '评论列表',
                'url' => ['/article-comments/index']
            ],
            [
                'label' => '评论审核',
                'url' => ['/comments/verify']
            ]
        ]
    ];
    $menuItems[] = [
        'label' => Yii::t('app', 'Categories'),
        'url' => ['/category/index']
    ];
    $menuItems[] = [
        'label' => Yii::t('app', 'User'),
        'url' => ['/user/index'],
        'items' => [
            [
                'label' => '用户列表',
                'url' => ['/user/index']
            ],
            [
                'label' => '用户审核',
                'url' => ['/user/verify']
            ],
            [
                'label' => '添加用户',
                'url' => ['/user/create']
            ]
        ]
    ];
    $menuItems[] = [
        'label' => Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
