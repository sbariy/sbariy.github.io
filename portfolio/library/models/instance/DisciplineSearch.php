<?php

namespace app\models\instance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\instance\Discipline;

/**
 * DisciplineSearch represents the model behind the search form about `app\models\instance\Discipline`.
 */
class DisciplineSearch extends Discipline
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'cycle.id', 'cycle.name'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'cycle.id',
            'cycle.name'
        ]);
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
        $query = Discipline::find()->joinWith('cycles');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = [
            'name' => SORT_ASC,
        ];

        $dataProvider->sort->attributes['cycle.name'] = [
            'asc' => [Cycle::tableName().'.name' => SORT_ASC],
            'desc' => [Cycle::tableName().'.name' => SORT_DESC],
            'default' => SORT_ASC
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cycle.id' => $this->getAttribute('cycle.id')
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
