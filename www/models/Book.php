<?php

namespace app\models;

use app\models\generated\Book as BaseBook;

/**
 * Модель подписки на автора.
 *
 * Расширяет сгенерированную Gii модель и используется в бизнес-логике приложения.
 */
class Book extends BaseBook
{
    /**
     * @var int[]
     */
    public array $authorIds = [];

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            ['authorIds', 'required'],
            ['authorIds', 'each', 'rule' => ['integer']],
        ]);
    }

    public function getAuthors()
    {
        return $this->hasMany(
            Author::class,
            ['id' => 'author_id']
        )->viaTable('book_author', ['book_id' => 'id']);
    }

    /**
     * Проверяет, существует ли активная подписка на автора.
     *
     * @param int $authorId Идентификатор автора
     * @param string $email Email подписчика
     * @return bool
     */
    public static function isSubscribed(int $authorId, string $email): bool
    {
        return static::find()
            ->where([
                'author_id' => $authorId,
                'email' => $email,
                'is_active' => 1,
            ])
            ->exists();
    }

    /**
     * Заполняет authorIds после загрузки модели
     */
    public function afterFind(): void
    {
        parent::afterFind();
        $this->authorIds = array_column($this->authors, 'id');
    }
}
