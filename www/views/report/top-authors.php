<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var int $year
 * @var array $authors
 */

$this->title = 'ТОП-10 авторов за ' . $year;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= Html::beginForm(['report/top-authors'], 'get') ?>
<label>
    Год:
    <input
        type="number"
        name="year"
        value="<?= Html::encode($year) ?>"
        min="1500"
        max="<?= date('Y') ?>"
    >
</label>
<button type="submit">Показать</button>
<?= Html::endForm() ?>


<?php if (empty($authors)): ?>
    <p>Нет данных за выбранный год.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
        <tr>
            <th>#</th>
            <th>Автор</th>
            <th>Количество книг</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($authors as $i => $author): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= Html::encode($author['full_name']) ?></td>
                <td><?= $author['books_count'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
