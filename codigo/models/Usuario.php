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
        return '{{%usuario}}'; // Asegúrese de que el nombre de la tabla sea correcto
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'username', 'password'], 'required'], //
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password'], 'string', 'min' => 6],
            [['password1', 'password2'], 'string', 'min' => 6],
            [['password2'], 'compare', 'compareAttribute' => 'password1', 'message' => 'Las contraseñas no coinciden'],
            [['role'], 'default', 'value' => 'normal'], // ✅  role valor default es normal
            [['role'], 'in', 'range' => ['normal', 'moderador', 'administrador', 'sysadmin']],
            ['status', 'in', 'range' => [0, 1], 'message' => 'El estado debe ser 0 (inactivo) o 1 (activo).'],
            ['phone', 'match', 'pattern' => '/^[6-9][0-9]{8}$/', 'message' => 'Por favor, introduce un número de teléfono español válido de 9 dígitos.'],
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
            [['role'], 'default', 'value' => 'normal'], // ✅  role valor default es normal
            [['role'], 'in', 'range' => ['normal', 'moderador', 'administrador', 'sysadmin']],
            [['auth_key'], 'string', 'max' => 255],
            'status' => 'Estado del Usuario',
            'phone' => 'Número de Teléfono', // anadir numero de telefono
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

