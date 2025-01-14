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
            [['email', 'nick', 'password'], 'required'], // ✅ 移除 role 作为必填项
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
            'id' => 'ID',
            'email' => 'Correo Electrónico',
            'nick' => 'Nombre de Usuario',
            'password' => 'Contraseña',
            'password1' => 'Nueva Contraseña',
            'password2' => 'Confirmar Nueva Contraseña',
            'role' => 'Rol de Usuario'
        ];
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
        return $this->password === $password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}

