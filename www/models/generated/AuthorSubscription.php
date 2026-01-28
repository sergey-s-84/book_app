<?php

namespace app\models\generated;

use Yii;

/**
 * This is the model class for table "author_subscription".
 *
 * @property int $id
 * @property int $author_id ID автора, на которого оформлена подписка
 * @property int|null $user_id ID пользователя (NULL для гостя)
 * @property string $phone Телефон для SMS уведомлений
 * @property int $is_active Флаг активности подписки
 * @property string|null $created_at Время создания подписки
 */
class AuthorSubscription extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author_subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'default', 'value' => null],
            [['is_active'], 'default', 'value' => 1],
            [['author_id', 'phone'], 'required'],
            [['author_id', 'user_id', 'is_active'], 'integer'],
            [['created_at'], 'safe'],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'ID автора, на которого оформлена подписка',
            'user_id' => 'ID пользователя (NULL для гостя)',
            'phone' => 'Телефон для SMS уведомлений',
            'is_active' => 'Флаг активности подписки',
            'created_at' => 'Время создания подписки',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AuthorSubscriptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthorSubscriptionQuery(get_called_class());
    }

}
