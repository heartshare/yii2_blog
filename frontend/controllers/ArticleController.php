<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Article;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller
{
    public function actionView($id)
    {
        if (!$article = Article::find()->with(['category', 'user'])->where('id =:id', [':id' => $id])->one()) {
            throw new NotFoundHttpException('ID为' . $id . '的文章被站长搞丢了诶o(╯□╰)o');
        }
        /* TODO 防刷新用的，暂时没有啥好解决办法，就酱紫用着吧！ */
        if (!\Yii::$app->session->get('article_view_' . $id)) {
            $article->updateCounters(['view' => 1]);
            \Yii::$app->session->set('article_view_' . $id, true);
        }
        return $this->render('view',
            ['article' => $article]
        );
    }

    /**
     * 文章列表页
     * @return string
     */
    public function actionList()
    {
        $newArticles = Article::getNewArticleList();
        $hotArticles = Article::getHotArticleList();
        return $this->render('list',
            [
                'newArticles' => $newArticles,
                'hotArticles' => $hotArticles
            ]
        );
    }

}
