<?php

namespace app\services;

use app\models\Author;

class AuthorService
{
    /**
     * Возвращает список авторов.
     *
     * @return array<int, string>
     */
    public static function findAll(): array
    {
        return Author::find()
            ->select(['full_name', 'id'])
            ->orderBy(['full_name' => SORT_ASC])
            ->indexBy('id')
            ->column();
    }
}
