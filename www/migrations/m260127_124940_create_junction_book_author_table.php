<?php

use yii\db\Migration;

/**
 * Миграция для создания таблицы `book_author` (таблица связи многие-ко-многим).
 */
class m260127_124940_create_junction_book_author_table extends Migration
{
    /**
     * Выполняет миграцию для создания таблицы `book_author`.
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer()->notNull()->comment('ID книги'),
            'author_id' => $this->integer()->notNull()->comment('ID автора'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->addPrimaryKey('pk-book_author', '{{%book_author}}', ['book_id', 'author_id']);

        $this->createIndex(
            'idx-book_author-book_id',
            '{{%book_author}}',
            'book_id'
        );

        $this->createIndex(
            'idx-book_author-author_id',
            '{{%book_author}}',
            'author_id'
        );

        $this->addForeignKey(
            'fk-book_author-book_id',
            '{{%book_author}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-book_author-author_id',
            '{{%book_author}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE'
        );
        $this->addCommentOnTable('{{%book_author}}', 'Таблица для связи книг с авторами (многие-ко-многим)');
    }

    /**
     * Выполняет откат миграции для удаления таблицы `book_author`.
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropCommentFromTable('{{%book_author}}');
        $this->dropForeignKey(
            'fk-book_author-book_id',
            '{{%book_author}}'
        );

        $this->dropForeignKey(
            'fk-book_author-author_id',
            '{{%book_author}}'
        );

        $this->dropIndex(
            'idx-book_author-book_id',
            '{{%book_author}}'
        );

        $this->dropIndex(
            'idx-book_author-author_id',
            '{{%book_author}}'
        );

        $this->dropTable('{{%book_author}}');
    }
}
