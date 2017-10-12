<?php

namespace app\models\instance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\instance\Bookcase;

/**
 * BookcaseSearch represents the model behind the search form about `app\models\instance\Bookcase`.
 */
class BookcaseSearch extends Bookcase
{
    public $amount;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bookcase', 'amount'], 'integer'],
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
        $query = Bookcase::find()->joinWith('bookshelves');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /*$dataProvider->sort->attributes['amount'] = [
            'asc' => ['amount' => SORT_ASC],
            'desc' => ['amount' => SORT_DESC],
            'default' => SORT_ASC
        ];*/

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        /*$query->andFilterWhere([
            'id' => $this->id,
            'bookcase' => $this->bookcase,
        ]);*/

        return $dataProvider;
    }
}
