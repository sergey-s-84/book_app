<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username Логин пользователя
 * @property string $email Email пользователя
 * @property string $phone Телефон пользователя
 * @property string $password_hash Хэш пароля
 * @property string $auth_key Ключ авторизации
 * @property string|null $created_at Время создания записи
 * @property string|null $updated_at Время последнего обновления записи
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'phone', 'password_hash', 'auth_key'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'email', 'phone', 'password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин пользователя',
            'email' => 'Email пользователя',
            'phone' => 'Телефон пользователя',
            'password_hash' => 'Хэш пароля',
            'auth_key' => 'Ключ авторизации',
            'created_at' => 'Время создания записи',
            'updated_at' => 'Время последнего обновления записи',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

}
