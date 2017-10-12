<?php

namespace app\models\instance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LocationSearch represents the model behind the search form about `app\models\instance\Location`.
 */
class BookshelfSearch extends Bookshelf
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bookshelf', 'bookcase_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Bookshelf::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'bookshelf' => $this->bookshelf,
            'bookcase_id' => $this->bookcase_id,
        ]);

        return $dataProvider;
    }
}
