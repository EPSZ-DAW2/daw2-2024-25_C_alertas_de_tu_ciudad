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
            [['nick', 'surname'], 'string', 'max' => 255], // Validación para 'nick' y 'surname'
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
            [['role'], 'default', 'value' => 'normal'],
            [['role'], 'in', 'range' => ['guest', 'normal', 'moderador', 'administrador', 'sysadmin']],
            [['auth_key'], 'string', 'max' => 255],
            [['nick', 'surname'], 'Apodo, Apellido'],
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


     /**
     * Verifica si el usuario es administrador del portal
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Verifica si el usuario es moderador
     * @return bool
     */
    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    /**
     * Verifica si el usuario es un usuario registrado
     * @return bool
     */
    public function isNormalUser()
    {
        return $this->role === 'normal';
    }

    /**
     * Verifica si el usuario es sysadmin
     * @return bool
     */
    public function isSysAdmin()
    {
        return $this->role === 'sysadmin';
    }

    /**
     * Verifica si el usuario es invitado (guest)
     * @return bool
     */
    public function isGuest()
    {
        return $this->role === 'guest';
    }
}

