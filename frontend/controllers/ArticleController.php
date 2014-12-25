<?php

namespace frontend\controllers;

use frontend\models\ArticleCommentForm;
use yii\web\Controller;
use common\models\Article;
use yii\web\NotFoundHttpException;

class ArticleController extends Controller
{
    public function actionView($id)
    {
        if (!$article = Article::getArticle($id)) {
            throw new NotFoundHttpException('ID为' . $id . '的文章被站长搞丢了诶o(╯□╰)o');
        }
        /* TODO 防刷新用的，暂时没有啥好解决办法，就酱紫用着吧！ */
        if (!\Yii::$app->session->get('article_view_' . $id)) {
            Article::findOne($id)->updateCounters(['view' => 1]);
            \Yii::$app->session->set('article_view_' . $id, true);
        }
        $articleCommentFormModel = new ArticleCommentForm();
        return $this->render('view',
            [
                'article' => $article,
                'articleCommentFormModel' => $articleCommentFormModel
            ]
        );
    }

    /**
     * 文章列表页
     * @return string
     */
    public function actionList()
    {
        $newArticles = Article::getArticleList();
        $hotArticles = Article::getArticleList(null, true);
        return $this->render('list',
            [
                'newArticles' => $newArticles,
                'hotArticles' => $hotArticles
            ]
        );
    }

}
