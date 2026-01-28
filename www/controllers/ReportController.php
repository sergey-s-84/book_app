<?php

namespace app\controllers;

use DateTime;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use app\services\AuthorReportService;

class ReportController extends Controller
{
    /**
     * ТОП-10 авторов по количеству книг за год.
     *
     * @return string
     * @throws Exception
     */
    public function actionTopAuthors(): string
    {
        $date = new DateTime();
        $year = (int)Yii::$app->request->get('year', $date->format('Y'));

        $authors = AuthorReportService::topAuthorsByYear($year, 10);

        return $this->render('top-authors', [
            'year' => $year,
            'authors' => $authors,
        ]);
    }
}
