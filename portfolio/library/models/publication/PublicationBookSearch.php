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

class PublicationBookSearch extends PublicationBook
{
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'publicationType.name',
            'publisher.name',
            'author.initials',
            'createdFrom',
            'createdTo',
            'author'
        ]);
    }
    public function rules()
    {
        return [
            [[
                'isbn',
                'name',
                'publishing_year',
                'createdFrom',
                'createdTo',
                'recommended',
                'publisher_id',
                'publication_type_id',
                'publicationType.name',
                'publisher.name',
                'author',
                'author.initials',
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
            'id' => 'Код',
            'isbn' => 'ISBN',
            'name' => 'Название',
            'recommended' => 'Рекоменд. Мин. обр.',
            'publisher.name' => 'Издатель',
            'publisher_id' => 'Издатель',
            'publicationType.name' => 'Вид издания',
            'publication_type_id' => 'Вид издания',
            'author' => 'Автор',
            'author.initials' => 'Автор',
            'createdFrom' => 'Год выпуска от',
            'createdTo' => 'Год выпуска до'
        ];
    }

    public function search($params)
    {
        $query = PublicationBook::find()
            ->joinWith([
                'publisher',
                'publicationType'
            ], false)
            ->joinWith([
                'authors',
                'publisher',
                'publicationInstances.bookshelf.bookcase'
            ])
            ->where(['type' => 'book'])->groupBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        $dataProvider->sort->defaultOrder = [
            'date_add' => SORT_DESC,
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

        $dataProvider->sort->attributes['author.initials'] = [
            'asc' => [Author::tableName().'.initials' => SORT_ASC],
            'desc' => [Author::tableName().'.initials' => SORT_DESC],
            'default' => SORT_ASC
        ];

        if (!$this->load($params) && $this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['recommended' => $this->recommended])
            ->andFilterWhere(['publisher.id' => $this->publisher_id])
            ->andFilterWhere(['publication_type.id' => $this->publication_type_id])
            ->andFilterWhere(['author.id' => $this->author]);


        $query->andFilterWhere(['like', 'isbn', $this->isbn])
            ->andFilterWhere(['like', 'publication.bbk', $this->bbk])
            ->andFilterWhere(['like', 'publication.name', $this->name])
            ->andFilterWhere(['>=', 'publishing_year', $this->createdFrom])
            ->andFilterWhere(['<=', 'publishing_year', $this->createdTo]);

        return $dataProvider;
    }
}