<?php

namespace frontend\controllers;

use common\models\ArticleComments;
use frontend\models\ArticleCommentForm;
use yii\web\Controller;
use common\models\Article;
use yii\web\ForbiddenHttpException;
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
        $articleCommentList = ArticleComments::findCommentListByArticleId($id);
        $articleCommentsTotal = ArticleComments::countCommentsByArticleId($id);
        $articleCommentFormModel = new ArticleCommentForm();
        return $this->render('view',
            [
                'article' => $article,
                'articleCommentList' => $articleCommentList,
                'articleCommentsTotal' => $articleCommentsTotal,
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

    /**
     * 用户添加评论
     * @return \yii\web\Response
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionComment()
    {
        if (!\Yii::$app->request->isAjax && !\Yii::$app->request->isPost) {
            throw new ForbiddenHttpException;
        }
        $model = new ArticleCommentForm();
        if ($model->load(\Yii::$app->request->post()) && $model->addComment()) {
            \Yii::$app->session->setFlash('success', \Yii::t('app', '{type} Published successfully.', ['type' => \Yii::t('app', 'Comments')]));
        } else {
            \Yii::$app->session->setFlash('error', \Yii::t('app', '{type} Published failed.', ['type' => \Yii::t('app', 'Comments')]));
        }
        return $this->goBack(\Yii::$app->request->referrer);
    }

}
