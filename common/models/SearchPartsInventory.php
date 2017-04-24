<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PartsInventory;

/**
 * SearchPartsInventory represents the model behind the search form about `common\models\PartsInventory`.
 */
class SearchPartsInventory extends PartsInventory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parts_id', 'old_quantity', 'new_quantity', 'type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['datetime_imported', 'created_at', 'updated_at'], 'safe'],
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
        $query = PartsInventory::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC]);

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
        $query->andFilterWhere(['like', 'parts_id', $this->parts_id])
            ->orFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
