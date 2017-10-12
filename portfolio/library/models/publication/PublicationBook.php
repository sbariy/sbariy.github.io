<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.04.2016
 * Time: 11:26
 */

namespace app\models\publication;

class PublicationBook extends Publication
{
    const TYPE = 'book';

    public function init()
    {
        $this->type = self::TYPE;
        parent::init();
    }

    public static function find()
    {
        return new PublicationQuery(get_called_class(), ['type' => self::TYPE]);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['isbn', 'unique']
        ]);
    }

    public function beforeSave($insert)
    {
        $this->type = self::TYPE;
        return parent::beforeSave($insert);
    }
}