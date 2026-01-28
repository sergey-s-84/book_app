<?php

use yii\db\Migration;
use yii\db\Query;

class m260128_085436_insert_books_with_authors extends Migration
{
    public function safeUp(): void
    {
        /*
         * Книги
         */
        $books = [
            ['Тени прошлого', 2021],
            ['Город без сна', 2021],
            ['Последний рассвет', 2021],
            ['Лабиринт памяти', 2021],
            ['Хроники ветра', 2021],
            ['Зов пустоты', 2021],
            ['За гранью слов', 2021],
            ['Искры во тьме', 2021],
            ['Молчание улиц', 2021],
            ['Отражение неба', 2021],
            ['Предел выбора', 2021],
            ['Пепел времени', 2021],
            ['Нить судьбы', 2021],
            ['Форма тишины', 2021],
            ['Сломанный горизонт', 2021],
            ['Сердце механизма', 2021],
            ['Осколки правды', 2021],
            ['Голос глубины', 2021],
            ['Зеркало миров', 2021],
            ['Точка возврата', 2021],
        ];

        $bookRows = [];
        foreach ($books as $book) {
            $bookRows[] = [
                $book[0],
                $book[1],
                'Тестовое описание книги.',
                mt_rand(1000000000, 9999999999),
                null,
            ];
        }

        $this->batchInsert('{{%book}}', [
            'title',
            'year',
            'description',
            'isbn',
            'cover_image',
        ], $bookRows);

        /*
         * Получаем авторов и книги
         */
        $authors = (new Query())
            ->from('{{%author}}')
            ->select('id')
            ->column();

        $books = (new Query())
            ->from('{{%book}}')
            ->select(['id', 'title'])
            ->orderBy('id')
            ->all();

        /*
         * Формируем связи
         */
        $relations = [];
        $bookIndex = 0;

        // 5 книг с 3 авторами
        for ($i = 0; $i < 5; $i++, $bookIndex++) {
            $authorIds = array_rand(array_flip($authors), 3);
            foreach ($authorIds as $authorId) {
                $relations[] = [$books[$bookIndex]['id'], $authorId];
            }
        }

        // 8 книг с 2 авторами
        for ($i = 0; $i < 8; $i++, $bookIndex++) {
            $authorIds = array_rand(array_flip($authors), 2);
            foreach ($authorIds as $authorId) {
                $relations[] = [$books[$bookIndex]['id'], $authorId];
            }
        }

        // остальные с 1 автором
        for (; $bookIndex < count($books); $bookIndex++) {
            $authorId = $authors[array_rand($authors)];
            $relations[] = [$books[$bookIndex]['id'], $authorId];
        }

        $this->batchInsert('{{%book_author}}', [
            'book_id',
            'author_id',
        ], $relations);
    }

    public function safeDown(): void
    {
        $this->delete('{{%book_author}}');

        $this->delete('{{%book}}', [
            'title' => [
                'Тени прошлого',
                'Город без сна',
                'Последний рассвет',
                'Лабиринт памяти',
                'Хроники ветра',
                'Зов пустоты',
                'За гранью слов',
                'Искры во тьме',
                'Молчание улиц',
                'Отражение неба',
                'Предел выбора',
                'Пепел времени',
                'Нить судьбы',
                'Форма тишины',
                'Сломанный горизонт',
                'Сердце механизма',
                'Осколки правды',
                'Голос глубины',
                'Зеркало миров',
                'Точка возврата',
            ],
        ]);
    }
}
