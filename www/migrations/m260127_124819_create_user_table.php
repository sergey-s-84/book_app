<?php

use yii\db\Migration;

/**
 * Миграция для создания таблицы `user`.
 */
class m260127_124819_create_user_table extends Migration
{
    /**
     * Выполняет миграцию для создания таблицы `user`.
     *
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull()->unique()->comment('Логин пользователя'),
            'email' => $this->string(255)->notNull()->unique()->comment('Email пользователя'),
            'phone' => $this->string(255)->notNull()->unique()->comment('Телефон пользователя'),
            'password_hash' => $this->string(255)->notNull()->comment('Хэш пароля'),
            'auth_key' => $this->string(32)->notNull()->comment('Ключ авторизации'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->comment('Время создания записи'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->comment('Время последнего обновления записи'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->addCommentOnTable('{{%user}}', 'Таблица для хранения информации о пользователях');
    }

    /**
     * Выполняет откат миграции для удаления таблицы `user`.
     *
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropCommentFromTable('{{%user}}');
        $this->dropTable('{{%user}}');
    }
}
