<?php
namespace app\services;

use app\models\Author;
use app\models\AuthorSubscription;
use app\models\Book;

/**
 * Сервис уведомлений о выходе новых книг.
 */
class BookNotificationService
{
    /**
     * Уведомляет подписчиков о выходе новой книги.
     *
     * @param Book $book
     * @return void
     */
    public static function notify(Book $book): void
    {
        /** @var Author $author */
        foreach ($book->authors as $author) {

            $subscriptions = AuthorSubscription::find()
                ->where([
                    'author_id' => $author->id,
                    'is_active' => 1,
                ])
                ->andWhere(['not', ['phone' => null]])
                ->all();

            foreach ($subscriptions as $subscription) {
                SmsService::send(
                    $subscription->phone,
                    self::buildMessage($book, $author)
                );
            }
        }
    }

    /**
     * Формирует текст SMS-уведомления о выходе новой книги автора.
     *
     * @param Book $book
     * @param Author $author
     * @return string
     */
    private static function buildMessage(Book $book, Author $author): string
    {
        return sprintf(
            'Новая книга автора %s: "%s" (%d)',
            $author->full_name,
            $book->title,
            $book->year
        );
    }
}
