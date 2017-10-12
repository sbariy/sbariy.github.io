<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 12.05.2016
 * Time: 21:07
 */

namespace app\models\instance;

use app\models\instance\PublicationInstance;
use app\models\publication\Article;
use app\models\publication\Publication;
use app\models\publication\Publisher;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use yii\data\Pagination;

class PeriodicalInstanceSearch extends PublicationInstance
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'priceFrom',
            'priceTo',
            'addedFrom',
            'addedTo',
            'publication.name',
            'publication.issn',
            'publication.releasedTo',
            'publication.releasedFrom',
            'publication.recommended',
            'publication.publisher_id',
            'publication.publisher.name',
            'publication.release_date',
            'publication.number',
            'publication.article.name',
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
                'publication.article.name',
                'publication.issn',
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
            'publication.releasedFrom' => 'Выпущено от',
            'publication.releasedTo' => 'Выпущено до',
            'publication.name' => 'Название',
            'publication.recommended' => 'Рек. Мин. обр.',
            'publication.publisher_id' => 'Издатель',
            'publication.publisher.name' => 'Издатели',
            'publication.publication_type_id' => 'Вид издания',
            'publication.article.name' => 'Статья',
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
                'publication.articles',
                'publication.authors',
            ])
            ->where(['type' => 'periodical'])->groupBy('id');

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

        $dataProvider->sort->attributes['publication.released_date'] = [
            'asc' => [Publication::tableName().'.release_date' => SORT_ASC],
            'desc' => [Publication::tableName().'.release_date' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['publication.publisher.name'] = [
            'asc' => [Publisher::tableName().'.name' => SORT_ASC],
            'desc' => [Publisher::tableName().'.name' => SORT_DESC],
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

        $dataProvider->sort->attributes['publication.article.name'] = [
            'asc' => [Article::tableName().'.name' => SORT_ASC],
            'desc' => [Article::tableName().'.name' => SORT_DESC],
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
            ->andFilterWhere(['like', 'publication.issn', $this->getAttribute('publication.issn')])
            ->andFilterWhere(['>=', 'publication.release_date', $this->getAttribute('publication.releasedFrom')])
            ->andFilterWhere(['<=', 'publication.release_date', $this->getAttribute('publication.releasedTo')])
            ->andFilterWhere(['>=', 'publication_instance.date_add', $this->addedFrom])
            ->andFilterWhere(['<=', 'publication_instance.date_add', $this->addedTo])
            ->andFilterWhere(['>=', 'price', $this->priceFrom])
            ->andFilterWhere(['<=', 'price', $this->priceTo])
            ->andFilterWhere(['like', 'article.name', $this->getAttribute('publication.article.name')]);
            //->andFilterWhere(['given' => $this->getAttribute('given')])

        return $dataProvider;
    }
}