<?php

namespace frontend\models;

use common\models\Article;
use Yii;
use yii\base\Model;

/**
 * ArticleCommentForm is the model behind the contact form.
 * @property string $email
 * @property string $site
 * @property string $nickname
 * @property string $content
 * @property integer $parent_id
 * @property integer $article_id
 * @property integer $reply_to
 */
class ArticleCommentForm extends Model
{
    public $email;
    public $site;
    public $nickname;
    public $content;
    public $verifyCode;
    public $parent_id;
    public $article_id;
    public $reply_to;
    private $_article;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['nickname', 'email', 'content'], 'required'],
            [['nickname', 'email', 'site'], 'trim'],
            [['parent_id', 'article_id', 'reply_to'], 'integer'],
            // email has to be a valid email address
            ['email', 'email'],
            ['site', 'url'],
            ['nickname', 'string', 'max' => 20],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
            ['article_id', 'validateArticleID']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => Yii::t('app', 'Verification Code'),
            'nickname' => Yii::t('app', 'Nickname'),
            'email' => Yii::t('app', 'Email'),
            'content' => Yii::t('app', 'Content'),
            'site' => Yii::t('app', 'Site'),
        ];
    }

    /**
     * Validates the article id.
     * This method serves as the inline validation for article id.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateArticleID($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->_article = Article::getArticle($this->article_id)) {
                $this->addError($attribute, Yii::t('app', 'Article') . '：' . $this->article_id . Yii::t('app', 'Not found'));
            }
        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            //setFrom参数的键值可以设置为发件人$this->email的邮箱地址，但是测试只有墙外的邮箱支持(比如Gmail)，国内如网易和腾讯都不支持，会报501错误，并提示不能用虚假邮箱地址。
            //如果使用国内邮箱发送，填发送邮件的邮箱地址即可。
            ->setFrom([Yii::$app->params['notificationEmail'] => $this->nickname])
            ->setSubject($this->subject)
            ->setTextBody('Form:' . $this->email . "\n" . $this->content)
            ->send();
    }
}
