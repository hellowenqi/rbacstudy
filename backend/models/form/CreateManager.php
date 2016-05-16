<?php
namespace backend\models\form;

use Yii;
use backend\models\Manager;
use yii\base\Model;

/**
 * Signup form
 */
class CreateManager extends Model
{
    public $username;
    public $email;
    public $password;
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'backend\models\Manager', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'backend\models\Manager', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['name', 'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if ($this->validate()) {
            $manager = new Manager();
            $manager->username = $this->username;
            $manager->email = $this->email;
            $manager->name = $this->name;
            $manager->setPassword($this->password);
            $manager->generateAuthKey();
            if ($manager->save()) {
                return $manager;
            }
        }

        return null;
    }
}
