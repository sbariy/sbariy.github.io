<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.05.2016
 * Time: 21:07
 */

namespace app\models\instance;

use app\models\publication\Author;
use app\models\publication\Publication;
use app\models\publication\Publisher;
use yii\data\ActiveDataProvider;
use yii\base\Model;

class BookInstanceSearch extends PublicationInstance
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'priceFrom',
            'priceTo',
            'addedFrom',
            'addedTo',
            'publication.name',
            'publication.isbn',
            'publication.bbk',
            'publication.releasedTo',
            'publication.releasedFrom',
            'publication.recommended',
            'publication.publisher_id',
            'publication.publisher.name',
            'publication.publishing_year',
            'publication.author_id',
            'publication.author.initials',
            'publication.publication_type_id',
            'bookshelf.bookshelf',
            'bookshelf.bookcase.bookcase'
        ]);
    }

    public function rules()
    {
        return [
            [[
                'id',
                'lost',
                'in_archive',
                'priceFrom',
                'priceTo',
                'addedFrom',
                'addedTo',
                'given',
                'cycle_id',
                'discipline_id',
                'bookshelf.bookcase.bookcase',
                'bookshelf.bookshelf',
                'publication.name',
                'publication.author.initials',
                'publication.author_id',
                'publication.isbn',
                'publication.bbk',
                'publication.recommended',
                'publication.releasedTo',
                'publication.releasedFrom',
                'publication.publisher_id',
                'publication.publisher.name',
                'publication.publication_type_id'
            ], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Инвентарный номер',
            'lost' => 'Утеряна',
            'given' => 'Выдана',
            'cycle_id' => 'Учебный цикл',
            'discipline_id' => 'Дисциплина',
            'in_archive' => 'В архиве',
            'priceTo' => 'Цена от',
            'priceFrom' => 'Цена до',
            'addedFrom' => 'Добавлено от',
            'addedTo' => 'Добавлено до',
            'publication.publishing_year',
            'publication.releasedFrom' => 'Год выпуска от',
            'publication.releasedTo' => 'Год выпуска до',
            'publication.name' => 'Название',
            'publication.bbk' => 'ББК',
            'publication.recommended' => 'Рек. Мин. обр.',
            'publication.publisher_id' => 'Издатель',
            'publication.publisher.name' => 'Издатели',
            'publication.publication_type_id' => 'Вид издания',
            'publication.author.initials' => 'Авторы',
            'publication.author_id' => 'Автор',
        ];
    }

    public function search($params)
    {
        $query = PublicationInstance::find()
            ->joinWith([
                'publication.publisher',
                'publication.publicationType'
            ], false)
            ->joinWith([
                'bookshelf.bookcase',
                'publication.authors',
            ])
            ->where(['type' => 'book'])->groupBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        $dataProvider->sort->defaultOrder = [
            'id' => SORT_DESC,
        ];

        $dataProvider->sort->attributes['publication.name'] = [
            'asc' => [Publication::tableName().'.name' => SORT_ASC],
            'desc' => [Publication::tableName().'.name' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['publication.publishing_year'] = [
            'asc' => [Publication::tableName().'.publishing_year' => SORT_ASC],
            'desc' => [Publication::tableName().'.publishing_year' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['publication.publisher.name'] = [
            'asc' => [Publisher::tableName().'.name' => SORT_ASC],
            'desc' => [Publisher::tableName().'.name' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['publication.author.initials'] = [
            'asc' => [Author::tableName().'.initials' => SORT_ASC],
            'desc' => [Author::tableName().'.initials' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['publication.recommended'] = [
            'asc' => [Publication::tableName().'.recommended' => SORT_ASC],
            'desc' => [Publication::tableName().'.recommended' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['publication.number'] = [
            'asc' => [Publication::tableName().'.number' => SORT_ASC],
            'desc' => [Publication::tableName().'.number' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['bookshelf.bookcase.bookcase'] = [
            'asc' => [Bookcase::tableName().'.bookcase' => SORT_ASC],
            'desc' => [Bookcase::tableName().'.bookcase' => SORT_DESC],
            'default' => SORT_ASC
        ];

        if (!$this->load($params) && $this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['publication_instance.id' => $this->id])
            ->andFilterWhere(['in_archive' => $this->in_archive])
            ->andFilterWhere(['cycle_id' => $this->cycle_id])
            ->andFilterWhere(['discipline_id' => $this->discipline_id])
            ->andFilterWhere(['lost' => $this->lost])
            ->andFilterWhere(['given' => $this->given])
            ->andFilterWhere(['publication.recommended' => $this->getAttribute('publication.recommended')])
            ->andFilterWhere(['publication.publisher_id' => $this->getAttribute('publication.publisher_id')])
            ->andFilterWhere(['publication.publication_type_id' => $this->getAttribute('publication.publication_type_id')])
            ->andFilterWhere(['author.id' => $this->getAttribute('publication.author_id')])
            ->andFilterWhere(['bookshelf.bookshelf' => $this->getAttribute('bookshelf.bookshelf')])
            ->andFilterWhere(['bookcase.bookcase' => $this->getAttribute('bookshelf.bookcase.bookcase')]);

        $query->andFilterWhere(['like', 'publication.name', $this->getAttribute('publication.name')])
            ->andFilterWhere(['like', 'publication.isbn', $this->getAttribute('publication.isbn')])
            ->andFilterWhere(['like', 'publication.bbk', $this->getAttribute('publication.bbk')])
            ->andFilterWhere(['>=', 'publication.publishing_year', $this->getAttribute('publication.releasedFrom')])
            ->andFilterWhere(['<=', 'publication.publishing_year', $this->getAttribute('publication.releasedTo')])
            ->andFilterWhere(['>=', 'publication_instance.date_add', $this->addedFrom])
            ->andFilterWhere(['<=', 'publication_instance.date_add', $this->addedTo])
            ->andFilterWhere(['>=', 'price', $this->priceFrom])
            ->andFilterWhere(['<=', 'price', $this->priceTo]);
            //->andFilterWhere(['given' => $this->getAttribute('given')])

        return $dataProvider;
    }
}