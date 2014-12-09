<?php
namespace frontend\controllers;

use common\models\Article;
use common\models\Category;
use yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;

class CategoryController extends Controller
{
    public function actionCategoryArticles($slug)
    {
        if (!$curCategory = Category::getCategoryBySlug($slug)) {
            throw new NotFoundHttpException('未找到相关分类o(╯□╰)o');
        };
        $categorys = Category::getCategoryList();
        $categoryArticles = Article::getArticleList($curCategory['id']);
        $hotArticles = Article::getArticleList($curCategory['id'], true);
        return $this->render('categoryArticles',
            [
                'categoryArticles' => $categoryArticles,
                'hotArticles' => $hotArticles,
                'categorys' => $categorys,
                'curCategory' => $curCategory
            ]
        );
    }
}