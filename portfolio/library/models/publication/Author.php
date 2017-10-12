<?php

namespace app\models\publication;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property string $id
 * @property string $initials
 *
 * @property AuthorPublication[] $authorPublications
 * @property Publication[] $publications
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['initials'], 'required'],
            [['initials'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'initials' => 'Инициалы',
        ];
    }

    public static function getListAuthorsForSelect($search, $attribute, $modelName)
    {
        $authors = [];
        if (!is_null($search)) {
            $query = $modelName::find()->joinWith(['publications'])->select(['author.id', 'author.initials'])->orderBy([$attribute => SORT_ASC]);
            if (preg_match('/^[*]+$/', $search)) {
                $authors = $query->asArray()->all();
            } else {
                $authors = $query->where(['like', $attribute, $search])->asArray()->all();
            }
        }
        return $authors;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorPublications()
    {
        return $this->hasMany(AuthorPublication::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublications()
    {
        return $this->hasMany(Publication::className(), ['id' => 'publication_id'])->viaTable('author_publication', ['author_id' => 'id']);
    }
}
