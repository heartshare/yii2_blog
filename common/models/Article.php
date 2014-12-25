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
 * @property string $create_at
 * @property string $update_at
 * @property integer $type
 * @property integer $status
 * @property integer $top
 * @property string $view
 * @property string $sort
 * @property string $slug
 * @property string $excerpt
 * @property string $password
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
            [['content', 'excerpt', 'title'], 'required'],
            [['content', 'excerpt'], 'string'],
            [['create_at', 'update_at', 'type', 'status', 'top', 'view', 'sort', 'allow_comment', 'user_id', 'category_id'], 'integer'],
            [['title', 'slug', 'password'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['slug'], 'unique'],
            [['title', 'slug'], 'filter', 'filter' => 'trim'],
            [
                'status',
                'in',
                'range' => [
                    self::STATUS_VERIFY,
                    self::STATUS_LUCK,
                    self::STATUS_PUBLISH
                ],
            ],
            ['status', 'default', 'value' => self::STATUS_VERIFY],
            [
                'type',
                'in',
                'range' => [
                    self::TYPE_ARTICLE
                ],
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
            'create_at' => Yii::t('app', 'Create Time'),
            'update_at' => Yii::t('app', 'Update Time'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'top' => Yii::t('app', 'Top'),
            'view' => Yii::t('app', 'View'),
            'sort' => Yii::t('app', 'Sort'),
            'slug' => Yii::t('app', 'Slug'),
            'excerpt' => Yii::t('app', 'Excerpt'),
            'password' => Yii::t('app', 'Password'),
            'allow_comment' => Yii::t('app', 'Allow Comment'),
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_at', 'update_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update_at',
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
     * @param bool $isHot 是否热门
     * @return array 文章列表和分页
     */
    public static function getArticleList($categoryId = null, $isHot = false)
    {
        $model = static::find()
            ->where(['status' => self::STATUS_PUBLISH])
            ->with(['category', 'user']);
        if (!empty($categoryId)) {
            $model->andWhere('category_id = :category_id', [':category_id' => $categoryId]);
        }
        $countQuery = clone $model;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        //如果是热门，则按查看次数和评论次数排序；否则按发表时间排序
        if ($isHot) {
            $model->orderBy('view DESC');
        } else {
            $model->orderBy('create_at DESC');
        }
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
     * 根据文章ID获取单条文章
     * @param integer $id 文章ID
     * @return array|null
     */
    public static function getArticle($id)
    {
        return $article = static::find()->with(['user', 'category'])->where('id = :id', [':id' => $id])->asArray()->one();
    }
}
