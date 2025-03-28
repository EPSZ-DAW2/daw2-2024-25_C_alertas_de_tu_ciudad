<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm es el modelo detrás del formulario de inicio de sesión.
 *
 * @property-read Usuario|null $user
 */
class LoginForm extends Model
{
    public $email; // <-- 修改这里，确保使用 `email` 而不是 `username`
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
{
    if (!$this->hasErrors()) {
        $user = $this->getUser();

        if (!$user) {
            $this->addError($attribute, 'Correo o contraseña incorrectos.');
            return;
        }

        // **调试输出**
        Yii::error("User password (from DB): " . $user->password, 'login');
        Yii::error("Input password: " . $this->password, 'login');

        // 如果数据库密码是明文，则直接比对
        if (strlen($user->password) < 20) {
            if ($this->password !== $user->password) {
                $this->addError($attribute, 'Correo o contraseña incorrectos.');
            }
        } else {
            // 正确使用 `password_verify()`
            if (!Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Correo o contraseña incorrectos.');
            }
        }
    }
}



    

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuario::findOne(['email' => $this->email]);
        }
        return $this->_user;
    }

}
