<?php

namespace app\models\publication;

use Yii;

/**
 * This is the model class for table "author_publication".
 *
 * @property string $publication_id
 * @property string $author_id
 *
 * @property Author $author
 * @property Publication $publication
 */
class AuthorPublication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'author_publication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['publication_id', 'author_id'], 'required'],
            [['publication_id', 'author_id'], 'integer'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['publication_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publication::className(), 'targetAttribute' => ['publication_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'publication_id' => 'Издание ID',
            'author_id' => 'Автор ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublication()
    {
        return $this->hasOne(Publication::className(), ['id' => 'publication_id']);
    }
}
