<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Usuario extends ActiveRecord implements IdentityInterface
{
    public $password1;
    public $password2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%usuario}}'; // 确保表名正确
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'username', 'password'], 'required'], // ✅ 移除 role 作为必填项
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password'], 'string', 'min' => 6],
            [['password1', 'password2'], 'string', 'min' => 6],
            [['password2'], 'compare', 'compareAttribute' => 'password1', 'message' => 'Las contraseñas no coinciden'],
            [['role'], 'default', 'value' => 'usuario'], // ✅ 让 role 默认值为 "usuario"
            [['role'], 'in', 'range' => ['usuario', 'moderador', 'administrador', 'sysadmin']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            [['email', 'username', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password'], 'string', 'min' => 6],
            [['password1', 'password2'], 'string', 'min' => 6],
            [['password2'], 'compare', 'compareAttribute' => 'password1', 'message' => 'Las contraseñas no coinciden'],
            [['role'], 'default', 'value' => 'usuario'],
            [['role'], 'in', 'range' => ['usuario', 'moderador', 'administrador', 'sysadmin']],
            [['auth_key'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]); // 确保 `usuario` 表中有 `auth_key` 字段
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findByUsername($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }
}

