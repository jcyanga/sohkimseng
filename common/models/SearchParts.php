<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Parts;

/**
 * SearchParts represents the model behind the search form about `common\models\Parts`.
 */
class SearchParts extends Parts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parts_category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['parts_code', 'parts_name', 'quantity', 'cost_price', 'gst_price', 'selling_price', 'unit_of_measure', 'created_at', 'updated_at'], 'safe'],
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
        $query = Parts::find()->where(['status' => 1]);

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
            'parts_category_id' => $this->parts_category_id,
            'parts_code' => $this->parts_code,
            'unit_of_measure' => $this->unit_of_measure,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'parts_name', $this->parts_name]);

        return $dataProvider;
    }
}
