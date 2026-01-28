<?php

use yii\db\Migration;

class m260127_125256_insert_test_users extends Migration
{
    /**
     * Добавляет тестовых пользователей в таблицу `user`.
     *
     * @return void
     * @throws Exception
     */
    public function safeUp(): void
    {
        $security = Yii::$app->security;

        $this->batchInsert('{{%user}}', [
            'username',
            'email',
            'phone',
            'password_hash',
            'auth_key',
        ], [
            [
                'admin',
                'admin@example.com',
                '79831002010',
                $security->generatePasswordHash('admin123'),
                $security->generateRandomString(),
            ],
            [
                'user1',
                'user1@example.com',
                '79831002020',
                $security->generatePasswordHash('password123'),
                $security->generateRandomString(),
            ],
            [
                'user2',
                'user2@example.com',
                '79831002030',
                $security->generatePasswordHash('password123'),
                $security->generateRandomString(),
            ],
        ]);
    }

    /**
     * Удаляет тестовых пользователей из таблицы `user`.
     *
     * @return void
     */
    public function safeDown(): void
    {
        $this->delete('{{%user}}', ['username' => ['admin', 'user1', 'user2']]);
    }
}
