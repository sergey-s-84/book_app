<?php

use yii\db\Migration;

/**
 * Миграция для создания таблицы `author`.
 */
class m260127_124913_create_author_table extends Migration
{
    /**
     * Выполняет миграцию для создания таблицы `author`.
     *
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string(255)->notNull()->comment('Полное имя автора'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');
        $this->addCommentOnTable('{{%author}}', 'Таблица для хранения информации об авторах');
    }

    /**
     * Выполняет откат миграции для удаления таблицы `author`.
     *
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropCommentFromTable('{{%author}}');
        $this->dropTable('{{%author}}');
    }
}
