<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Article;
use yii\widgets\PjaxAsset;

class ArticleController extends Controller
{
    public function actionView($id)
    {
        $article = Article::find()->with(['category', 'user'])->where('id =:id', [':id' => $id])->asArray()->one();
        return $this->render('view',
            ['article' => $article]
        );
    }

}
