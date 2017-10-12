<?php

namespace app\models\instance;

use Yii;

/**
 * This is the model class for table "location".
 *
 * @property integer $id
 * @property integer $bookshelf
 * @property integer $bookcase_id
 *
 * @property PublicationInstance[] $publicationInstances
 */
class Bookshelf extends \yii\db\ActiveRecord
{
    public $amount;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bookshelf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bookshelf', 'bookcase_id'], 'required'],
            [['bookshelf', 'bookcase_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bookshelf' => 'Полка',
            'bookcase_id' => 'Шкаф',
        ];
    }

    public static function getBookshelvesByBookcase($bookcase_id)
    {
        $bookshelves = self::find()->select(['bookshelf', 'id'])->indexBy('id')->where(['bookcase_id' => $bookcase_id])->column();
        return $bookshelves;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicationInstances()
    {
        return $this->hasMany(PublicationInstance::className(), ['bookshelf_id' => 'id']);
    }

    public function getBookcase()
    {
        return $this->hasOne(Bookcase::className(), ['id' => 'bookcase_id']);
    }
}
