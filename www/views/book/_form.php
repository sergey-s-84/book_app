<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\forms\BookForm;

/**
 * @var yii\web\View $this
 * @var BookForm $form
 * @var array $authors
 */

$activeForm = ActiveForm::begin();
?>

<?= $activeForm->field($form, 'title')->textInput(['maxlength' => true]) ?>
<?= $activeForm->field($form, 'year')->input('number') ?>
<?= $activeForm->field($form, 'description')->textarea(['rows' => 4]) ?>
<?= $activeForm->field($form, 'isbn')->textInput(['maxlength' => true]) ?>
<?= $activeForm->field($form, 'authorIds')->checkboxList($authors) ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>
</div>

<?php ActiveForm::end(); ?>
