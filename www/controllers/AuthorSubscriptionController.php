<?php

namespace app\controllers;

use app\models\forms\AuthorSubscribeForm;
use Yii;
use yii\db\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\services\AuthorSubscriptionService;

/**
 * Контроллер подписки на авторов.
 */
class AuthorSubscriptionController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Создаёт подписку на автора.
     *
     * @param int $author_id
     * @return Response
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionCreate(int $author_id): Response
    {
        $model = new AuthorSubscribeForm();

        if (!Yii::$app->user->isGuest) {
            $model->phone = Yii::$app->user->identity->phone;
        }

        if ($model->load(Yii::$app->request->post())) {
            $created = AuthorSubscriptionService::subscribe(
                $author_id,
                $model->phone,
                Yii::$app->user->isGuest ? null : Yii::$app->user->id
            );

            Yii::$app->session->setFlash(
                $created ? 'success' : 'info',
                $created
                    ? 'Вы успешно подписались на автора'
                    : 'Вы уже подписаны на этого автора'
            );

            return $this->redirect(Yii::$app->request->referrer ?: ['/site/index']);
        }

        throw new BadRequestHttpException();
    }

}
