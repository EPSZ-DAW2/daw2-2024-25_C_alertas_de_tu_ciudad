<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Usuario extends ActiveRecord implements IdentityInterface
{   
    public $password1;
    public $password2;
    public $nick; 
    public $surname; 
    public $currentPassword; 
    public $newPassword; 
    public $confirmPassword; 
    


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%usuario}}'; 
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'username', 'password', 'nick', 'surname'], 'required'], // 
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password'], 'string', 'min' => 6],
            [['password1', 'password2'], 'string', 'min' => 6],
            [['password2'], 'compare', 'compareAttribute' => 'password1', 'message' => 'Las contraseñas no coinciden'],
            [['role'], 'default', 'value' => 'usuario'], 
            [['role'], 'in', 'range' => ['usuario', 'moderador', 'administrador', 'sysadmin']],
            [['nick', 'surname'], 'string', 'max' => 255], 
            [['username', 'email'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 255],
            [['username', 'email', 'password'], 'required'], // 保持已有的规则
            [['created_at', 'updated_at'], 'safe'], // 添加对时间戳字段的验证规则
            [['failed_attempts', 'is_locked'], 'safe'], // 确保字段可保存
            [['failed_attempts'], 'integer'], // 必须是整数
            [['is_locked'], 'boolean'], // 布尔值

         
            [['currentPassword', 'newPassword', 'confirmPassword'], 'required', 'on' => 'changePassword'],
            ['currentPassword', 'validateCurrentPassword', 'on' => 'changePassword'],
            ['newPassword', 'string', 'min' => 6, 'on' => 'changePassword'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Las contraseñas no coinciden.', 'on' => 'changePassword'],
        ];
    }

    /**
     * 
     */
    public function validateCurrentPassword($attribute, $params)
    {
        if (!Yii::$app->security->validatePassword($this->$attribute, $this->password)) {
            $this->addError($attribute, 'La contraseña actual es incorrecta.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Correo Electrónico', 
            'username' => 'Nombre de Usuario', 
            'password' => 'Contraseña', 
            'nick' => 'Apodo', 
            'surname' => 'Apellido', 
            'role' => 'Rol de Usuario', 
            'auth_key' => 'Clave de Autenticación', 
            'currentPassword' => 'Contraseña Actual', 
            'newPassword' => 'Nueva Contraseña', 
            'confirmPassword' => 'Confirmar Contraseña', 
            'created_at' => 'Fecha de Creación',
            'updated_at' => 'Fecha de Actualización',
            'status' => 'Estado',
            'failed_attempts' => 'Intentos Fallidos',
            'is_locked' => 'Bloqueado',
        ];
    }

public function beforeSave($insert)
{
    if (parent::beforeSave($insert)) {
        if ($insert) {
            $this->created_at = date('Y-m-d H:i:s'); // 设置创建时间
        }
        $this->updated_at = date('Y-m-d H:i:s'); // 每次保存时更新更新时间

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
        return static::findOne(['auth_key' => $token]); 
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
        $this->password = Yii::$app->security->generatePasswordHash($password);
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
        return $this->role === 'moderador';
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
    /**
 * 锁定用户
 */
public function lock()
{
    $this->is_locked = 1; // 设置锁定状态为1
    $this->failed_attempts = 0; // 清除失败尝试次数
    return $this->save(false); // 跳过验证直接保存
}

/**
 * 解锁用户
 */
public function unlock()
{
    $this->is_locked = 0; // 设置锁定状态为0
    return $this->save(false); // 跳过验证直接保存
}

}
