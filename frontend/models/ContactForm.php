<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => Yii::t('app', 'Verification Code'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Body')
        ];
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
            ->setFrom([Yii::$app->params['notificationEmail'] => $this->name])
            ->setSubject($this->subject)
            ->setTextBody('Form:' . $this->email . "\n" . $this->body)
            ->send();
    }
}
