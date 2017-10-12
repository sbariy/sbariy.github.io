<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 24.05.2016
 * Time: 11:28
 */

namespace app\models\publication;

use yii\data\ActiveDataProvider;
use yii\base\Model;

class PublicationPeriodicalSearch extends PublicationPeriodical
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'publicationType.name',
            'publisher.name',
            'author',
            'article.name',
            'createdFrom',
            'createdTo'
        ]);
    }
    public function rules()
    {
        return [
            [['createdFrom', 'createdTo', 'publisher_id', 'publication_type_id', 'publicationType.name', 'publisher.name', 'recommended', 'name', 'issn', 'release_date', 'author', 'article.name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'issn' => 'ISSN',
            'name' => 'Название',
            'recommended' => 'Рекоменд. Мин. обр.',
            'publisher.name' => 'Издатель',
            'publisher_id' => 'Издатель',
            'publicationType.name' => 'Вид издания',
            'publication_type_id' => 'Вид издания',
            'author' => 'Автор',
            'article.name' => 'Статья',
            'createdFrom' => 'Выпущено от',
            'createdTo' => 'Выпущено до'
        ];
    }

    public function search($params)
    {
        $query = PublicationPeriodical::find()
            ->joinWith([
                'publisher',
                'publicationType'
            ], false)
            ->joinWith([
                'articles',
                'authors',
                'publisher',
                'publicationInstances.bookshelf.bookcase'
            ])
            ->groupBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        $dataProvider->sort->defaultOrder = [
            'id' => SORT_DESC,
        ];

        $dataProvider->sort->attributes['publisher.name'] = [
            'asc' => [Publisher::tableName().'.name'=> SORT_ASC],
            'desc' => [Publisher::tableName().'.name'=> SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['publicationType.name'] = [
            'asc' => [PublicationType::tableName().'.name'=> SORT_ASC],
            'desc' => [PublicationType::tableName().'.name'=> SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['author'] = [
            'asc' => [Author::tableName().'.name' => SORT_ASC],
            'desc' => [Author::tableName().'.name' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $dataProvider->sort->attributes['article.name'] = [
            'asc' => [Article::tableName().'.name' => SORT_ASC],
            'desc' => [Article::tableName().'.name' => SORT_DESC],
            'default' => SORT_ASC
        ];

        if (!$this->load($params) && $this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['recommended' => $this->recommended])
            ->andFilterWhere(['publisher.id' => $this->publisher_id])
            ->andFilterWhere(['publication_type.id' => $this->publication_type_id])
            ->andFilterWhere(['author.id' => $this->author]);


        $query->andFilterWhere(['like', 'issn', $this->issn])
            ->andFilterWhere(['like', 'publication.name', $this->name])
            ->andFilterWhere(['>=', 'release_date', $this->createdFrom])
            ->andFilterWhere(['<=', 'release_date', $this->createdTo])
            ->andFilterWhere(['like', 'article.name', $this->getAttribute('article.name')]);

        return $dataProvider;
    }
}