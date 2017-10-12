<?php

namespace app\models\publication;

use app\models\instance\PublicationInstance;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "publication".
 *
 * @property string $id
 * @property string $isbn
 * @property string $issn
 * @property string $bbk
 * @property string $name
 * @property string $year_publishing
 * @property string $release_date
 * @property integer $recommended
 * @property string $number
 * @property string $type
 * @property string $annotation
 * @property string $publication_type_id
 * @property string $publisher_id
 *
 * @property Article[] $articles
 * @property AuthorPublication[] $authorPublications
 * @property Author[] $authors
 * @property Book[] $books
 * @property DisciplinePublication[] $disciplinePublications
 * @property Discipline[] $disciplines
 * @property PublicationType $publicationType
 * @property Publisher $publisher
 */
class Publication extends \yii\db\ActiveRecord
{
    private $_authorsArray;
    public $addedFrom;
    public $addedTo;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'publication';
    }


    public static function find()
    {
        return new PublicationQuery(get_called_class());
    }

    public static function instantiate($row)
    {
        switch ($row['type']) {
            case PublicationPeriodical::TYPE:
                return new PublicationPeriodical();
            case PublicationBook::TYPE:
                return new PublicationBook();
            default:
                return new self;
        }
    }


    public function rules()
    {
        return [
            [['publishing_year', 'recommended', 'number', 'publication_type_id', 'publisher_id'], 'integer'],
            ['authorsArray', 'safe'],
            [['release_date'], 'date', 'format' => 'yyyy-mm-dd'],
            [['annotation'], 'string'],
            [['publisher_id', 'name'], 'required'],
            [['isbn', 'issn', 'bbk', 'name', 'type'], 'string', 'max' => 255],
            //[['publication_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PublicationType::className(), 'targetAttribute' => ['publication_type_id' => 'id']],
            [['publisher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publisher::className(), 'targetAttribute' => ['publisher_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'isbn' => 'ISBN',
            'issn' => 'ISSN',
            'bbk' => 'ББК',
            'name' => 'Название',
            'publishing_year' => 'Год выпуска',
            'release_date' => 'Дата выпуска',
            'date_add' => 'Дата добавления',
            'recommended' => 'Рек. Мин. обр.',
            'number' => 'Номер',
            'type' => 'Тип',
            'annotation' => 'Аннотация',
            'publication_type_id' => 'Вид издания',
            'publisher_id' => 'Издатель',
            'authorsArray' => 'Авторы',
        ];
    }
    /* Save/Update authors */
    public function getAuthorsArray()
    {
        if ($this->_authorsArray === null) {
            $this->_authorsArray = $this->getAuthors()->select('id')->column();
        }
        return $this->_authorsArray;
    }
    public function setAuthorsArray($value)
    {
        $this->_authorsArray = (array) $value;
    }
    private function updateAuthors()
    {
        $currentAuthorsIds = $this->getAuthors()->select('id')->column();
        $newAuthorsIds = $this->getAuthorsArray();

        foreach (array_filter(array_diff($newAuthorsIds, $currentAuthorsIds)) as $authorId) {
            /** @var Tag $tag */
            if ($author = Author::findOne($authorId)) {
                $this->link('authors', $author);
            }
        }
        foreach (array_filter(array_diff($currentAuthorsIds, $newAuthorsIds)) as $authorId) {
            /** @var Tag $tag */
            if ($author = Author::findOne($authorId)) {
                $this->unlink('authors', $author, true);
            }
        }
    }

    public static function getListPublicationForSelect($search, $attribute, $modelName)
    {
        $publications = [];
        if (!is_null($search)) {
            $query = $modelName::find()->joinWith(['authors'])->joinWith(['publicationType'], false)->select(['publication.id', 'publication.name', 'number', 'publication_type.name AS publicationType'])->orderBy(['publication.id' => SORT_DESC]);
            if (preg_match('/^[*]+$/', $search)) {
                $publications = $query->asArray()->all();
            } else {
                $publications = $query->where(['like', $attribute, $search])->asArray()->all();
            }
        }
        return $publications;
    }


    /* InitValueText Select2 */
    public function getInitAuthors()
    {
        return $this->getAuthors()->select(['initials', 'id'])->where(['id' => $this->getAuthorsArray()])->indexBy('id')->column();
    }
    public function getInitPublisher()
    {
        return $this->getPublisher()->select(['name', 'id'])->where(['id' => $this->publisher_id])->indexBy('id')->column();
    }
    public function getInitPublicationType ()
    {
        return $this->getPublicationType()->select(['name', 'id'])->where(['id' => $this->publication_type_id])->indexBy('id')->column();
    }

    /* Идентификация издания в Select2, доделать! */
    public function getPublicationInLine()
    {
        return $this->name .' | '. $this->getAuthorsToString() .' | '. $this->type === 'periodical' ? $this->release_date : $this->year_publishing;
    }

    // List records in GridView
    public function getAuthorsToString()
    {
        $result = null;

        foreach ($this->authors as $author) {
            $result .= Html::tag('p', $author->initials);
        }
        return $result;
    }
    public function getArticlesToString()
    {
        $result = null;

        foreach ($this->articles as $article) {
            $result .= Html::tag('p', $article->name . '&nbsp[' . $article->pages . ']', ['class' => 'list-in-grid-view']);
        }
        return $result;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updateAuthors();
        parent::afterSave($insert, $changedAttributes);
    }



    /* Relations */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['publication_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorPublications()
    {
        return $this->hasMany(AuthorPublication::className(), ['publication_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::className(), ['id' => 'author_id'])->viaTable('author_publication', ['publication_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicationInstances()
    {
        return $this->hasMany(PublicationInstance::className(), ['publication_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplinePublications()
    {
        return $this->hasMany(DisciplinePublication::className(), ['publication_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplines()
    {
        return $this->hasMany(Discipline::className(), ['id' => 'discipline_id'])->viaTable('discipline_publication', ['publication_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicationType()
    {
        return $this->hasOne(PublicationType::className(), ['id' => 'publication_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublisher()
    {
        return $this->hasOne(Publisher::className(), ['id' => 'publisher_id']);
    }

    /**
     * @inheritdoc
     * @return PublicationQuery the active query used by this AR class.
     */



    /* Overrides */


}
