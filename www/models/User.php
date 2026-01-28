<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use app\models\generated\User as BaseUser;

/**
 * Модель пользователя приложения.
 *
 * Расширяет сгенерированную Gii модель пользователя и добавляет логику аутентификации и авторизации
 * через реализацию IdentityInterface.
 */
class User extends BaseUser implements IdentityInterface
{
    /**
     * Возвращает пользователя по его первичному ключу.
     *
     * @param int|string $id
     * @return IdentityInterface|null
     */
    public static function findIdentity($id): ?IdentityInterface
    {
        return static::findOne($id);
    }

    /**
     * Поиск пользователя по access token.
     * В рамках данного проекта не используется, поэтому метод всегда возвращает null.
     *
     * @param string $token
     * @param mixed|null $type
     * @return IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        return null;
    }

    /**
     * Поиск пользователя по логину.
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username): ?self
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Возвращает идентификатор пользователя.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Возвращает ключ авторизации пользователя.
     * Используется для проверки подлинности сессии и механизма "запомнить меня".
     *
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * Проверяет корректность ключа авторизации.
     *
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Проверяет корректность введённого пароля.
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword(
            $password,
            $this->password_hash
        );
    }
}
