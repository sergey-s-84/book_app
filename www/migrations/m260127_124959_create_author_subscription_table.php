<?php

use yii\db\Migration;

/**
 * Миграция для создания таблицы `author_subscription`.
 */
class m260127_124959_create_author_subscription_table extends Migration
{
    /**
     * Выполняет миграцию для создания таблицы `author_subscription`.
     *
     * @return void
     */
    public function safeUp(): void
    {

        $this->createTable('{{%author_subscription}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull()->comment('ID автора, на которого оформлена подписка'),
            'user_id' => $this->integer()->comment('ID пользователя (NULL для гостя)'),
            'phone' => $this->string(20)->notNull()->comment('Телефон для SMS уведомлений'),
            'is_active' => $this->boolean()->notNull()->defaultValue(true)->comment('Флаг активности подписки'),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->comment('Время создания подписки'),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        $this->createIndex(
            'idx-author_subscription-author_id-phone',
            '{{%author_subscription}}',
            ['author_id', 'phone'],
            true
        );

        $this->addForeignKey(
            'fk-author_subscription-author_id',
            '{{%author_subscription}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE'
        );
        $this->addCommentOnTable('{{%author_subscription}}', 'Таблица для подписок пользователей на авторов');
    }

    /**
     * Выполняет откат миграции для удаления таблицы `author_subscription`.
     *
     * @return void
     */
    public function safeDown(): void
    {
        $this->dropCommentFromTable('{{%author_subscription}}');
        $this->dropForeignKey(
            'fk-author_subscription-author_id',
            '{{%author_subscription}}'
        );

        $this->dropIndex(
            'idx-author_subscription-author_id-phone',
            '{{%author_subscription}}'
        );

        $this->dropTable('{{%author_subscription}}');
    }
}
