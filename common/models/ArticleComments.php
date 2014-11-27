<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article_comments}}".
 *
 * @property string $id
 * @property string $content
 * @property string $create_time
 * @property string $ip
 * @property string $agent
 * @property string $reply_to
 * @property string $parent_id
 * @property integer $status
 * @property string $article_id
 * @property string $user_id
 *
 * @property Article $article
 * @property User $user
 */
class ArticleComments extends \yii\db\ActiveRecord
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
            [['content', 'user_id'], 'required'],
            [['content'], 'string'],
            [['create_time', 'reply_to', 'parent_id', 'status', 'article_id', 'user_id'], 'integer'],
            [['ip'], 'string', 'max' => 100],
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
            'create_time' => Yii::t('app', 'Create Time'),
            'ip' => Yii::t('app', 'Ip'),
            'agent' => Yii::t('app', 'Agent'),
            'reply_to' => Yii::t('app', 'Reply To'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'status' => Yii::t('app', 'Status'),
            'article_id' => Yii::t('app', 'Article ID'),
            'user_id' => Yii::t('app', 'User ID'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
