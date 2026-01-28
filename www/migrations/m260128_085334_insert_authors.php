<?php

use yii\db\Migration;

class m260128_085334_insert_authors extends Migration
{
    /**
     * Список авторов.
     */
    private const AUTHORS = [
        ['Иван Северный'],
        ['Артём Лисов'],
        ['Мария Громова'],
        ['Николай Вересов'],
        ['Ольга Миронова'],
        ['Дмитрий Коваль'],
        ['Анна Полякова'],
        ['Сергей Романов'],
        ['Екатерина Белова'],
        ['Максим Орехов'],
        ['Денис Пернатов'],
        ['Алла Новикова'],
        ['Дмитрий Суриков'],
        ['Денис Ермолов'],
        ['Антон Филипов'],
    ];


    /**
     * Добавляет тестовых авторов.
     *
     * @return void
     */
    public function safeUp(): void
    {
        $this->batchInsert('{{%author}}', ['full_name'], self::AUTHORS);
    }

    /**
     * Удаляет тестовых авторов.
     *
     * @return void
     */
    public function safeDown(): void
    {
        $this->delete('{{%author}}', [
            'full_name' => array_column(self::AUTHORS, 0),
        ]);
    }
}
