<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title Название книги
 * @property int|null $year Год выпуска
 * @property string|null $description Описание книги
 * @property string|null $isbn ISBN книги
 * @property string|null $cover_image Путь или URL к обложке
 * @property string|null $created_at Время создания записи
 * @property string|null $updated_at Время последнего обновления записи
 *
 * @property Author[] $authors
 * @property BookAuthor[] $bookAuthors
 */
class Book extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'description', 'isbn', 'cover_image'], 'default', 'value' => null],
            [['title'], 'required'],
            [['year'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'cover_image'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 13],
            [['isbn'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название книги',
            'year' => 'Год выпуска',
            'description' => 'Описание книги',
            'isbn' => 'ISBN книги',
            'cover_image' => 'Путь или URL к обложке',
            'created_at' => 'Время создания записи',
            'updated_at' => 'Время последнего обновления записи',
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery|AuthorQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('book_author', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery|BookAuthorQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return BookQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BookQuery(get_called_class());
    }

}
