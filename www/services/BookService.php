<?php

namespace app\services;

use app\models\Author;
use app\models\forms\BookForm;
use DomainException;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use app\models\Book;

/**
 * Сервис управления книгами.
 *
 * Отвечает за:
 * - создание книги
 * - обновление книги
 * - удаление книги
 */
class BookService
{
    /**
     * Создаёт новую книгу.
     *
     * @param Book $book
     * @param BookForm $form
     * @return Book
     * @throws Throwable
     * @throws Exception
     */
    public static function createFromForm(Book $book, BookForm $form): Book
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $book->setAttributes($form->attributes, false);

            if (!$book->save(false)) {
                throw new DomainException('Не удалось сохранить книгу');
            }

            $book->unlinkAll('authors', true);

            foreach ($form->authorIds as $authorId) {
                $book->link('authors', Author::findOne($authorId));
            }

            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        BookNotificationService::notify($book);

        return $book;
    }


    /**
     * Обновляет существующую книгу.
     *
     * @param Book $book
     * @param BookForm $form
     * @return Book
     * @throws Exception
     * @throws Throwable
     */
    public static function updateFromForm(Book $book, BookForm $form): Book
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $book->setAttributes($form->attributes, false);

            if (!$book->save(false)) {
                throw new DomainException('Не удалось обновить книгу');
            }

            $book->unlinkAll('authors', true);

            foreach ($form->authorIds as $authorId) {
                $book->link('authors', Author::findOne($authorId));
            }

            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $book;
    }

    /**
     * Удаляет книгу.
     *
     * @param int $id
     * @return void
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public static function delete(int $id): void
    {
        $model = self::find($id);

        Yii::$app->db->transaction(function () use ($model) {

            $model->unlinkAll('authors', true);

            if ($model->delete() === false) {
                throw new DomainException('Не удалось удалить книгу');
            }
        });
    }

    /**
     * Находит книгу или выбрасывает исключение.
     *
     * @param int $id
     * @return Book
     * @throws NotFoundHttpException
     */
    public static function find(int $id): Book
    {
        $model = Book::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException('Книга не найдена');
        }

        return $model;
    }

    /**
     * Находит книгу или выбрасывает исключение.
     *
     * @return Book[]
     */
    public static function findAll(): array
    {
        return Book::find()->all();
    }
}
