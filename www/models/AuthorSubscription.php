<?php

namespace app\models;

use app\models\generated\AuthorSubscription as BaseAuthorSubscription;
use yii\db\Exception;

/**
 * Модель подписки на автора.
 * Расширяет сгенерированную Gii модель и используется в бизнес-логике приложения.
 */
class AuthorSubscription extends BaseAuthorSubscription
{
    /**
     * Возвращает активную подписку, если она существует.
     *
     * @param int $authorId
     * @param string $phone
     * @return self|null
     */
    public static function findActive(int $authorId, string $phone): ?self
    {
        return self::find()
            ->where([
                'author_id' => $authorId,
                'phone' => $phone,
                'is_active' => 1,
            ])
            ->one();
    }

    /**
     * Создаёт новую подписку.
     *
     * @param int $authorId
     * @param string $phone
     * @param int|null $userId
     * @return self
     * @throws Exception
     */
    public static function create(int $authorId, string $phone, ?int $userId): self
    {
        $model = new self();
        $model->author_id = $authorId;
        $model->phone = $phone;
        $model->user_id = $userId;
        $model->is_active = 1;

        if (!$model->save()) {
            throw new \DomainException('Не удалось создать подписку');
        }

        return $model;
    }
}
