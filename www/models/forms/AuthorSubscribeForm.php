<?php

namespace app\models\forms;

use yii\base\Model;

/**
 * Форма подписки на автора.
 */
class AuthorSubscribeForm extends Model
{
    public ?string $phone = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['phone', 'required'],
            ['phone', 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
        ];
    }
}
