<?php

namespace app\models\publication;

/**
 * This is the ActiveQuery class for [[Publication]].
 *
 * @see Publication
 */
class PublicationQuery extends \yii\db\ActiveQuery
{
    public $type;

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function prepare($builder)
    {
        if ($this->type !== null) {
            $this->andWhere(['type' => $this->type]);
        }
        return parent::prepare($builder);
    }

    /**
     * @inheritdoc
     * @return Publication[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Publication|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
