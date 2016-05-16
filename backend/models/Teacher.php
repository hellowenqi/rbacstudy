<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "teacher".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property integer $schoolID
 * @property integer $created_at
 * @property integer $updated_at
 */
class Teacher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teacher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'name', 'schoolID', 'created_at', 'updated_at'], 'required'],
            [['schoolID', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password', 'name'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'schoolID' => 'School ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
