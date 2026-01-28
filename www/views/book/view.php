<?php

use yii\helpers\Html;
use app\models\Book;

/**
 * @var yii\web\View $this
 * @var Book $model
 */

$this->title = $model->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Год:</strong> <?= Html::encode($model->year) ?></p>

<?php if ($model->description): ?>
    <p><?= nl2br(Html::encode($model->description)) ?></p>
<?php endif; ?>

<p><strong>ISBN:</strong> <?= Html::encode($model->isbn) ?></p>

<p>
    <?= Html::a('Назад к списку', ['site/index']) ?>
</p>

<?php if (!Yii::$app->user->isGuest): ?>
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id]) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'data-method' => 'post',
            'data-confirm' => 'Удалить книгу?',
        ]) ?>
    </p>
<?php endif; ?>
