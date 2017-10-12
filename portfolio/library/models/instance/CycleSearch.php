<?php

namespace app\models\instance;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\instance\Cycle;

/**
 * CycleSearch represents the model behind the search form about `app\models\instance\Cycle`.
 */
class CycleSearch extends Cycle
{

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'disciplines.name',
            'disciplinesArray',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'duration', 'year_adoption'], 'integer'],
            [['name', 'disciplines.name', 'disciplinesArray'], 'safe'],
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
        $query = Cycle::find()->joinWith(['disciplines'])->groupBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = [
            'name' => SORT_ASC,
        ];

        $dataProvider->sort->attributes['disciplines.name'] = [
            'asc' => [Discipline::tableName().'.name' => SORT_ASC],
            'desc' => [Discipline::tableName().'.name' => SORT_DESC],
            'default' => SORT_ASC
        ];

        if (!$this->load($params) && $this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'duration' => $this->duration,
        ]);

        $query->andFilterWhere(['discipline.id' => $this->getAttribute('disciplinesArray')])
            ->andFilterWhere(['year_adoption' => $this->year_adoption]);

        $query->andFilterWhere(['like', 'cycle.name', $this->name]);


        return $dataProvider;
    }
}
