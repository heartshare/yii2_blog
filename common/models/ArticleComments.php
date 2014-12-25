<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%article_comments}}".
 *
 * @property string $id
 * @property string $site
 * @property string $nickname
 * @property string $email
 * @property string $content
 * @property string $create_at
 * @property string $ip
 * @property string $agent
 * @property string $reply_to
 * @property string $parent_id
 * @property integer $status
 * @property string $article_id
 *
 * @property Article $article
 */
class ArticleComments extends ActiveRecord
{
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
            [['create_at', 'reply_to', 'parent_id', 'status', 'article_id'], 'integer'],
            [['ip'], 'string', 'max' => 100],
            ['email', 'email'],
            ['nickname', 'string', 'max' => 20],
            ['site', 'url'],
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
            'reply_to' => Yii::t('app', 'Reply To'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'status' => Yii::t('app', 'Status'),
            'article_id' => Yii::t('app', 'Article ID'),
            'nickname' => Yii::t('app', 'Nickname'),
            'email' => Yii::t('app', 'Email'),
            'site' => Yii::t('app', 'Site')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

}
