<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Usuario extends ActiveRecord implements IdentityInterface
{
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;
    public $password1;
    public $password2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%usuario}}'; // 数据库表名
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'username', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password'], 'string', 'min' => 6],
            [['nick'], 'string', 'max' => 255], // 添加 nick 字段的验证规则

            // 密码修改规则
            [['currentPassword', 'newPassword', 'confirmPassword'], 'required', 'on' => 'changePassword'],
            ['currentPassword', 'validateCurrentPassword', 'on' => 'changePassword'],
            ['newPassword', 'string', 'min' => 6, 'on' => 'changePassword'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Las contraseñas no coinciden.', 'on' => 'changePassword'],

            // 时间戳字段
            [['created_at', 'updated_at'], 'safe'],

            // 其他规则
            [['failed_attempts'], 'integer'], // 登录失败次数
            [['is_locked'], 'boolean'], // 锁定状态

            [['estado_revisar'], 'string', 'max' => 20], // 允许更新 estado_revisar

            [['respuesta'], 'string'], // 确保 respuesta 是字符串类型
            
            [['role'], 'in', 'range' => ['normal', 'moderator', 'admin', 'sysadmin']],

            [['eliminar_razon'], 'string'],  // 添加删除原因的验证规则
        ];
    }

    /**
     * 验证当前密码是否正确
     */
    public function validateCurrentPassword($attribute, $params)
{
    if (!$this->hasErrors()) {
        // 获取当前用户
        $user = Usuario::findOne($this->id);

        if (!$user) {
            $this->addError($attribute, 'Usuario no encontrado.');
            return;
        }

        // **调试输出**
        Yii::error("User password (from DB): " . $user->password, 'change-password');
        Yii::error("Input current password: " . $this->$attribute, 'change-password');

        // 如果数据库密码是明文，则直接比对
        if (strlen($user->password) < 20) {
            if ($this->$attribute !== $user->password) {
                $this->addError($attribute, 'La contraseña actual es incorrecta.');
            }
        } else {
            // 正确使用 `password_verify()`
            if (!Yii::$app->security->validatePassword($this->$attribute, $user->password)) {
                $this->addError($attribute, 'La contraseña actual es incorrecta.');
            }
        }
    }
}


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Correo Electrónico',
            'username' => 'Nombre de Usuario',
            'password' => 'Contraseña',
            'currentPassword' => 'Contraseña Actual',
            'newPassword' => 'Nueva Contraseña',
            'confirmPassword' => 'Confirmar Contraseña',
            'created_at' => 'Fecha de Creación',
            'updated_at' => 'Fecha de Actualización',
            'failed_attempts' => 'Intentos Fallidos',
            'is_locked' => 'Estado de Bloqueo',
            'nick' => 'Apodo', // 添加 nick 的标签
            'estado_revisar' => 'Estado de Revisión',
            'respuesta' => 'Respuesta',
            'eliminarrazon' => 'Eliminar de Razon', 
            'role'=> 'Role', 
            'eliminar_razon' => 'Razón de Eliminación',
        ];
    }

    /**
     * 在保存前更新时间戳
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->created_at = date('Y-m-d H:i:s'); // 设置创建时间
            }
            $this->updated_at = date('Y-m-d H:i:s'); // 更新更新时间
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * 获取用户 ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 获取认证密钥
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * 验证认证密钥
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 通过用户名查找用户
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * 验证密码
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * 设置密码（哈希加密）
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 锁定用户
     */
    public function lock()
    {
        $this->is_locked = true;
        $this->failed_attempts = 0; // 重置失败次数
        return $this->save(false); // 跳过验证直接保存
    }

    /**
     * 解锁用户
     */
    public function unlock()
    {
        $this->is_locked = false;
        return $this->save(false); // 跳过验证直接保存
    }
    
}
