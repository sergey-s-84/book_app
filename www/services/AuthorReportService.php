<?php

namespace app\services;

use Yii;
use yii\db\Exception;

/**
 * Сервис отчётов по авторам.
 */
class AuthorReportService
{
    /**
     * Возвращает ТОП-10 авторов по количеству книг за год.
     *
     * @param int $year
     * @param int $limit
     * @return array
     * @throws Exception
     */
    public static function topAuthorsByYear(int $year, int $limit = 10): array
    {
        return Yii::$app->db->createCommand(
            "
            SELECT
                a.id,
                a.full_name,
                COUNT(b.id) AS books_count
            FROM author a
            JOIN book_author ba ON ba.author_id = a.id
            JOIN book b ON b.id = ba.book_id
            WHERE b.year = :year
            GROUP BY a.id, a.full_name
            ORDER BY books_count DESC
            LIMIT :limit
            ",
            [':year' => $year, ':limit' => $limit]
        )->queryAll();
    }
}
