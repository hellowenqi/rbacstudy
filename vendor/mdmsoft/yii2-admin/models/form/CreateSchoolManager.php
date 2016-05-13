<?php
namespace mdm\admin\models\form;

use Yii;
use mdm\admin\models\Manager;
use yii\base\Model;

/**
 * Signup form
 */
class CreateSchoolManager extends Model
{
    public $username;
    public $email;
    public $name;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'mdm\admin\models\Manager', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => 'mdm\admin\models\Manager', 'message' => 'This school has already been in use.'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'mdm\admin\models\Manager', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs manager up.
     *
     * @return SchoolManager|null the saved model or null if saving fails
     */
    public function signup()
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
