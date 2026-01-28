<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\forms\BookForm $form
 * @var array $authors
 */

$this->title = 'Редактировать книгу: ' . $form->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'form' => $form,
    'authors' => $authors,
]) ?>
