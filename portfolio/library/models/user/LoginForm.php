<?php

namespace app\models\user;

use Yii;
use yii\base\Model;
use app\models\user\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attributeName)
    {
        if ($this->hasErrors()) {
            return;
        }
        $user = $this->getUser($this->username);

        if (!($user and $this->isCorrectHash($this->$attributeName, $user->password))) {
            $this->addError('password', 'Некорректное имя пользователя или пароль.');
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if (!$this->validate())
            return false;

        $user = $this->getUser($this->username);
        if (!$user)
            return false;

        return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser($username)
    {
        if (!$this->_user) {
            $this->_user = $this->fetchUser($username);
        }

        return $this->_user;
    }

    public function fetchUser($username)
    {
        return User::findOne(compact('username'));
    }

    public function isCorrectHash($plaintext, $password)
    {
        return Yii::$app->security->validatePassword($plaintext, $password);
    }
}
