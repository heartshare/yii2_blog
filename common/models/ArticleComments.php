<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%article_comments}}".
 *
 * @property string  $id
 * @property string  $site
 * @property string  $nickname
 * @property string  $email
 * @property string  $content
 * @property string  $create_at
 * @property string  $ip
 * @property string  $agent
 * @property string  $parent_id
 * @property integer $status
 * @property string  $article_id
 *
 * @property Article $article
 */
class ArticleComments extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_PUBLISH = 1;
    const STATUS_LUCK = 2;
    const STATUS_VERIFY = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'nickname', 'email'], 'required'],
            [['content'], 'string'],
            [['create_at', 'parent_id', 'status', 'article_id'], 'integer'],
            [['ip'], 'string', 'max' => 100],
            ['email', 'email'],
            ['nickname', 'string', 'max' => 20],
            ['site', 'url'],
            [
                'status',
                'in',
                'range' => [
                    self::STATUS_PUBLISH,
                    self::STATUS_DELETED,
                    self::STATUS_LUCK,
                    self::STATUS_VERIFY
                ]
            ],
            ['status', 'default', 'value' => self::STATUS_VERIFY],
            [['agent'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'create_at' => Yii::t('app', 'Create Time'),
            'ip' => Yii::t('app', 'Ip'),
            'agent' => Yii::t('app', 'Agent'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'status' => Yii::t('app', 'Status'),
            'article_id' => Yii::t('app', 'Article ID'),
            'nickname' => Yii::t('app', 'Nickname'),
            'email' => Yii::t('app', 'Email'),
            'site' => Yii::t('app', 'Site')
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_at'],
                ],
            ]
        ];
    }

    /**
     * 根据ID查询单条评论
     *
     * @param integer $id ID
     *
     * @return static
     */
    public static function findCommentById($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_PUBLISH]);
    }

    /**
     * 根据文章ID查询评论
     *
     * @param integer $articleId 文章ID
     *
     * @return array
     */
    public static function findCommentListByArticleId($articleId)
    {
        $model = static::find()
            ->where(['status' => self::STATUS_PUBLISH])
            ->andWhere('article_id = :article_id', ['article_id' => $articleId]);
        $countQuery = clone $model;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 10]);
        $model->orderBy('create_at DESC');
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
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * 获取文章的评论统计
     * @param integer $articleId 文章ID
     *
     * @return int
     */
    public static function countCommentsByArticleId($articleId)
    {
        return static::find()->where('article_id = :article_id', [':article_id' => $articleId])
            ->andWhere(['status' => self::STATUS_PUBLISH])
            ->count();
    }
}
