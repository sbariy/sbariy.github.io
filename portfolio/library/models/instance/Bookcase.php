<?php

namespace app\models\instance;

use Yii;

/**
 * This is the model class for table "bookcase".
 *
 * @property string $id
 * @property string $bookcase
 *
 * @property Bookshelf[] $bookshelves
 */
class Bookcase extends \yii\db\ActiveRecord
{
    public $amount_bookshelves;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bookcase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bookcase', 'amount_bookshelves'], 'required'],
            [['bookcase', 'amount_bookshelves'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bookcase' => 'Шкаф',
            'amount_bookshelves' => 'Кол-во полок'
        ];
    }

    public function getAmount () {
        return $this->getBookshelves()->count();
    }

    public static function getBookshelvesByBookcase($bookcase_id)
    {
        return self::find()->select(['id', 'bookshelf'])->indexBy('id')->where(['bookcase_id' => $bookcase_id])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookshelves()
    {
        return $this->hasMany(Bookshelf::className(), ['bookcase_id' => 'id']);
    }
}
