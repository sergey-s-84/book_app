<?php

namespace app\services;

use yii\db\Exception;
use yii\web\BadRequestHttpException;
use app\models\Author;
use app\models\AuthorSubscription;

/**
 * Сервис управления подписками на авторов.
 *
 * Отвечает за:
 * - проверку входных данных
 * - проверку бизнес-ограничений
 * - координацию создания подписки
 *
 * Контроллеры используют данный сервис как
 * единую точку входа для бизнес-логики.
 */
class AuthorSubscriptionService
{

    /**
     * Создаёт подписку на автора. Если активная подписка уже существует — ничего не делает.
     *
     * @param int $authorId
     * @param string|null $phone
     * @param int|null $userId
     * @return bool
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public static function subscribe(int $authorId, ?string $phone, ?int $userId): bool
    {
        self::assertPhoneExists($phone);
        self::assertAuthorExists($authorId);

        if (AuthorSubscription::findActive($authorId, $phone) !== null) {
            return false;
        }

        AuthorSubscription::create($authorId, $phone, $userId);

        return true;
    }

    /**
     * Проверяет существование phone.
     *
     * @param string|null $phone
     * @return void
     * @throws BadRequestHttpException
     */
    private static function assertPhoneExists(?string $phone): void
    {
        if (empty($phone)) {
            throw new BadRequestHttpException('Телефон не указан');
        }
    }

    /**
     * Проверяет существование автора.
     *
     * @param int $authorId
     * @return void
     * @throws BadRequestHttpException
     */
    private static function assertAuthorExists(int $authorId): void
    {
        if (!Author::find()->where(['id' => $authorId])->exists()) {
            throw new BadRequestHttpException('Автор не найден');
        }
    }
}
