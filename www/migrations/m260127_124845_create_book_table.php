<?php

use yii\db\Migration;

/**
 * Миграция для создания таблицы `book`.
 */
class m260127_124845_create_book_table extends Migration
{
    /**
     * Выполняет миграцию для создания таблицы `book`.
     *
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название книги'),
            'year' => $this->smallInteger()->comment('Год выпуска'),
            'description' => $this->text()->comment('Описание книги'),
            'isbn' => $this->string(13)->unique()->comment('ISBN книги'),
            'cover_image' => $this->string(255)->comment('Путь или URL к обложке'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->comment('Время создания записи'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->comment('Время последнего обновления записи'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');
        $this->addCommentOnTable('{{%book}}', 'Таблица для хранения информации о книгах');
    }

    /**
     * Выполняет откат миграции для удаления таблицы `book`.
     *
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropCommentFromTable('{{%book}}');
        $this->dropTable('{{%book}}');
    }
}
