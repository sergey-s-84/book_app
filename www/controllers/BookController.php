<?php

namespace app\controllers;

use app\models\Author;
use app\models\forms\BookForm;
use app\services\AuthorService;
use app\services\BookService;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Book;
use yii\web\Response;

class BookController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'actions' => ['index', 'view'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Список книг (доступно всем)
     */
    public function actionIndex(): string
    {
        $books = Book::find()->with('authors')->all();

        return $this->render('index', [
            'books' => $books,
        ]);
    }

    /**
     * Просмотр книги (доступно всем)
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => BookService::find($id),
        ]);
    }

    /**
     * Добавление книги (только юзер)
     *
     * @return string|Response
     * @throws Throwable
     */
    public function actionCreate(): Response|string
    {
        $book = new Book();
        $form = BookForm::createEmpty();
        $authors = AuthorService::findAll();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            BookService::createFromForm($book, $form);

            Yii::$app->session->setFlash('success', 'Книга добавлена');
            return $this->redirect(['view', 'id' => $book->id]);
        }

        return $this->render('create', [
            'form' => $form,
            'book' => $book,
            'authors' => $authors,
        ]);
    }

    /**
     * Редактирование книги (только юзер)
     *
     * @param int $id
     * @return Response|string
     * @throws NotFoundHttpException
     * @throws Throwable
     */
    public function actionUpdate(int $id): Response|string
    {
        $book = BookService::find($id);
        $authors = AuthorService::findAll();

        $form = BookForm::createFromBook($book);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            BookService::updateFromForm($book, $form);

            Yii::$app->session->setFlash('success', 'Книга обновлена');
            return $this->redirect(['view', 'id' => $book->id]);
        }

        return $this->render('update', [
            'form' => $form,
            'book' => $book,
            'authors' => $authors,
        ]);
    }


    /**
     * Удаление книги (только юзер)
     *
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDelete(int $id): Response
    {
        BookService::delete($id);

        Yii::$app->session->setFlash('success', 'Книга удалена');
        return $this->redirect(['site/index']);
    }

}

