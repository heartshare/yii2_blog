<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\rbac\Role;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $username
 * @property string $nickname
 * @property string $email
 * @property integer $gender
 * @property string $phone
 * @property string $password_hash
 * @property string $profile
 * @property string $avatar
 * @property string $create_time
 * @property string $update_time
 * @property string $active_time
 * @property integer $status
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $site
 * @property string $role_id
 *
 * @property string $password
 *
 * @property Album[] $albums
 * @property Article[] $articles
 * @property ArticleComments[] $articleComments
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_LUCK = 2;
    const STATUS_VERIFY = 3;
    const ROLE_USER = 2;
    const ROLE_ADMIN = 1;
    const GENDER_GIRL = 0;
    const GENDER_BOY = 1;

    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'active_time', 'update_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gender', 'phone', 'create_time', 'update_time', 'active_time', 'status', 'role_id'], 'integer'],
            [['username', 'nickname'], 'string', 'max' => 45],
            [['email', 'password_hash', 'profile', 'site'], 'string', 'max' => 255],
            [['avatar', 'auth_key', 'password_reset_token'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['nickname'], 'unique'],
            [['email'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_VERIFY],
            [
                'status',
                'in',
                'range' => [
                    self::STATUS_ACTIVE,
                    self::STATUS_DELETED,
                    self::STATUS_LUCK,
                    self::STATUS_VERIFY
                ]
            ],
            ['gender', 'default', 'value' => self::GENDER_BOY],
            ['password', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'nickname' => Yii::t('app', 'Nickname'),
            'email' => Yii::t('app', 'Email'),
            'gender' => Yii::t('app', 'Gender'),
            'phone' => Yii::t('app', 'Phone'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'profile' => Yii::t('app', 'Profile'),
            'avatar' => Yii::t('app', 'avatar'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'active_time' => Yii::t('app', 'Active Time'),
            'status' => Yii::t('app', 'Status'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'site' => Yii::t('app', 'Site'),
            'role_id' => Yii::t('app', 'Role ID'),
            'password' => Yii::t('app', 'password')
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->password)) {
                $this->setPassword($this->password);
            }
            if (empty($this->nickname)) {
                $this->nickname = $this->username;
            }
            if (empty($this->role_id)) {
                //TODO Yii2的RBAC还不会，所以先随机读取一个^_^
                $this->role_id = \common\models\Role::find()->one()->id;
            }
            if ($this->isNewRecord) {
            }
            return true;
        }
        return false;
    }

    public function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'Active'),
            self::STATUS_DELETED => Yii::t('app', 'Delete'),
            self::STATUS_LUCK => Yii::t('app', 'Luck'),
            self::STATUS_VERIFY => Yii::t('app', 'Verify')
        ];
    }

    public function getGenderOptions()
    {
        return [
            self::GENDER_GIRL => Yii::t('app', 'girl'),
            self::GENDER_BOY => Yii::t('app', 'boy')
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Album::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleComments()
    {
        return $this->hasMany(ArticleComments::className(), ['user_id' => 'id']);
    }

    public function getRoles()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }
}
