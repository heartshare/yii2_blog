<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $create_time
 * @property string $update_time
 * @property integer $type
 * @property integer $status
 * @property integer $top
 * @property string $view
 * @property string $sort
 * @property string $slug
 * @property string $excerpt
 * @property string $password
 * @property integer $allow_comment
 * @property string $comments_total
 * @property string $user_id
 * @property integer $category_id
 *
 * @property User $user
 * @property Category $category
 * @property ArticleComments[] $articleComments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'excerpt'], 'required'],
            [['content', 'excerpt'], 'string'],
            [['create_time', 'update_time', 'type', 'status', 'top', 'view', 'sort', 'allow_comment', 'comments_total', 'user_id', 'category_id'], 'integer'],
            [['title', 'slug', 'password'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['slug'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'top' => Yii::t('app', 'Top'),
            'view' => Yii::t('app', 'View'),
            'sort' => Yii::t('app', 'Sort'),
            'slug' => Yii::t('app', 'Slug'),
            'excerpt' => Yii::t('app', 'Excerpt'),
            'password' => Yii::t('app', 'Password'),
            'allow_comment' => Yii::t('app', 'Allow Comment'),
            'comments_total' => Yii::t('app', 'Comments Total'),
            'user_id' => Yii::t('app', 'User ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleComments()
    {
        return $this->hasMany(ArticleComments::className(), ['article_id' => 'id']);
    }
}
