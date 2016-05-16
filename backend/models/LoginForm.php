<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
    const IDENTITY_STUDENT = 0;
    const IDENTITY_TEACHER = 1;
    const IDENTITY_MANAGER = 2;

    public $username;
    public $password;
    public $identity;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
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

            ['identity', 'default', 'value' => self::IDENTITY_STUDENT],
            ['identity', 'in', 'range' => [self::IDENTITY_STUDENT, self::IDENTITY_TEACHER, self::IDENTITY_MANAGER]],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            if($this->identity == 2)
            {
                $this->_user = User::findByUsername($this->username);
            }
//            else if($this->identity ==1)
//            {
//                $this->_user = Teacher::findByUsername($this->username);
//            }
//            else if($this->identity ==0 )
//            {
//                $this->_user = Student::findByUsername($this->username);
//            }

        }

        return $this->_user;
    }
}
