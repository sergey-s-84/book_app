<?php

namespace app\models\generated;

/**
 * This is the ActiveQuery class for [[AuthorSubscription]].
 *
 * @see AuthorSubscription
 */
class AuthorSubscriptionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AuthorSubscription[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AuthorSubscription|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
