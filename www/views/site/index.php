<?php

use app\models\forms\AuthorSubscribeForm;
use app\models\Book;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var Book[] $books
 */

$this->title = 'Каталог книг';
?>

    <h1><?= $this->title ?></h1>

<?php if (!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Добавить книгу', ['book/create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php endif; ?>


<?php if (empty($books)): ?>
    <p>Книги не найдены.</p>
<?php else: ?>
    <ul>
        <?php foreach ($books as $book): ?>
            <li>
                <strong><?= htmlspecialchars($book->title) ?></strong>
                (<?= $book->year ?>)
                <br>

                <em>
                    Авторы:
                    <?php foreach ($book->authors as $author): ?>

                        <?= htmlspecialchars($author->full_name) ?>

                        <?php

                        $formModel = new AuthorSubscribeForm();

                        if (!Yii::$app->user->isGuest) {
                            $formModel->phone = Yii::$app->user->identity->phone;
                        }
                        ?>

                        <?php $form = ActiveForm::begin([
                            'method' => 'post',
                            'action' => ['/author-subscription/create', 'author_id' => $author->id],
                            'options' => ['style' => 'display:inline'],
                        ]); ?>

                        <?php if (Yii::$app->user->isGuest): ?>
                            <?= $form->field($formModel, 'phone')
                                ->input('phone', ['placeholder' => 'Телефон'])
                                ->label(false) ?>
                        <?php else: ?>
                            <?= $form->field($formModel, 'phone')
                                ->hiddenInput()
                                ->label(false) ?>
                        <?php endif; ?>

                        <button type="submit">Подписаться</button>

                        <?php ActiveForm::end(); ?>

                        <br>
                    <?php endforeach; ?>
                </em>

            </li>
            <?php if (!Yii::$app->user->isGuest): ?>
                <?= Html::a('Редактировать', ['book/update', 'id' => $book->id]) ?>
                <?= Html::a('Удалить', ['book/delete', 'id' => $book->id], [
                    'data-method' => 'post',
                    'data-confirm' => 'Удалить книгу?',
                ]) ?>
            <?php endif; ?>

        <?php endforeach; ?>
    </ul>
<?php endif; ?>