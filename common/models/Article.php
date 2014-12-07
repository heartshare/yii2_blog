<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\db\ActiveRecord;

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
class Article extends ActiveRecord
{
    const TYPE_ARTICLE = 0;
    const STATUS_PUBLISH = 1;
    const STATUS_VERIFY = 0;
    const STATUS_LUCK = 2;

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
            [['content', 'excerpt', 'title'], 'required', 'message' => '{attribute}不能为空'],
            [['content', 'excerpt'], 'string'],
            [['create_time', 'update_time', 'type', 'status', 'top', 'view', 'sort', 'allow_comment', 'comments_total', 'user_id', 'category_id'], 'integer'],
            [['title', 'slug', 'password'], 'string', 'max' => 255],
            [['title'], 'unique', 'message' => '{attribute}:"{value}"已经存在~\(≧▽≦)/~啦啦啦'],
            [['slug'], 'unique', 'message' => '{attribute}:"{value}"已经存在~\(≧▽≦)/~啦啦啦'],
            [['title', 'slug'], 'filter', 'filter' => 'trim'],
            [
                'status',
                'in',
                'range' => [
                    self::STATUS_VERIFY,
                    self::STATUS_LUCK,
                    self::STATUS_PUBLISH
                ],
                'message' => '{attribute}非法'
            ],
            ['status', 'default', 'value' => self::STATUS_VERIFY],
            [
                'type',
                'in',
                'range' => [
                    self::TYPE_ARTICLE
                ],
                'message' => '{attribute}非法'
            ],
            ['type', 'default', 'value' => self::TYPE_ARTICLE],
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
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                ],
            ]
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->user_id = Yii::$app->user->id;
            $this->slug = empty($this->slug) ? $this->title : $this->slug;
            if ($this->isNewRecord) {
            }
            return true;
        }
        return false;
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

    public function getTypesOptions()
    {
        return [
            self::TYPE_ARTICLE => '文章'
        ];
    }

    public function getStatusOptions()
    {
        return [
            self::STATUS_VERIFY => '待审核',
            self::STATUS_PUBLISH => '发布',
            self::STATUS_LUCK => '锁定'
        ];
    }

    /**
     * 获得最新的文章列表
     * @param null|string $categoryId 分类ID
     * @return array 文章列表和分页
     */
    public static function getNewArticleList($categoryId = null)
    {
        $model = static::find()
            ->where(['status' => self::STATUS_PUBLISH])
            ->with(['category', 'user'])
            ->orderBy('create_time DESC');
        if (!empty($categoryId)) {
            $model->andWhere('category_id = :category_id', [':category_id' => $categoryId]);
        }
        $countQuery = clone $model;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        return [
            'list' => $model
                ->limit($pages->limit)
                ->offset($pages->offset)
                ->asArray()
                ->all(),
            'pages' => $pages
        ];
    }

    /**
     * 获取热门文章
     * @param null|string $categoryId 分类ID
     * @return array 文章列表和分页
     */
    public static function getHotArticleList($categoryId = null)
    {
        $model = static::find()
            ->where(['status' => self::STATUS_PUBLISH])
            ->orderBy('view DESC,comments_total DESC');
        if (!empty($categoryId)) {
            $model->andWhere('category_id = :category_id', [':category_id' => $categoryId]);
        }
        $countQuery = clone $model;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        return [
            'list' => $model->limit($pages->limit)
                ->offset($pages->offset)
                ->asArray()
                ->all(),
            'pages' => $pages
        ];
    }
}
