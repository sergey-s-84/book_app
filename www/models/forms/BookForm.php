<?php

namespace app\models\forms;

use yii\base\Model;
use app\models\Book;

/**
 * Форма создания и редактирования книги.
 */
class BookForm extends Model
{
    public ?int $id = null;
    public string $title = '';
    public ?int $year = null;
    public ?string $description = null;
    public ?string $isbn = null;
    public array $authorIds = [];

    /**
     * Правила валидации формы.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [['title', 'year', 'description', 'isbn', 'authorIds'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['isbn'], 'string', 'max' => 255],
            [
                'isbn',
                'unique',
                'targetClass' => Book::class,
                'filter' => function ($query) {
                    if ($this->id !== null) {
                        $query->andWhere(['<>', 'id', $this->id]);
                    }
                },
            ],
            [['authorIds'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * Создаёт форму для редактирования существующей книги.
     *
     * @param Book $book
     * @return self
     */
    public static function createFromBook(Book $book): self
    {
        $form = new self();
        $form->id = $book->id;
        $form->setAttributes($book->attributes);
        $form->authorIds = $book->authorIds;

        return $form;
    }

    /**
     * Создаёт пустую форму для добавления книги.
     *
     * @return self
     */
    public static function createEmpty(): self
    {
        return new self();
    }
}
