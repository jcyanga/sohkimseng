<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PurchaseOrder;

/**
 * SearchPurchaseOrder represents the model behind the search form about `common\models\PurchaseOrder`.
 */
class SearchPurchaseOrder extends PurchaseOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'supplier_id', 'payment_type_id', 'status', 'created_by', 'paid', 'deleted'], 'integer'],
            [['purchase_order_code', 'date_issue', 'remarks', 'created_at'], 'safe'],
            [['grand_total', 'gst', 'gst_value', 'net'], 'number'],
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
        $query = PurchaseOrder::find();

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
            'user_id' => $this->user_id,
            'supplier_id' => $this->supplier_id,
            'date_issue' => $this->date_issue,
            'grand_total' => $this->grand_total,
            'gst' => $this->gst,
            'gst_value' => $this->gst_value,
            'net' => $this->net,
            'payment_type_id' => $this->payment_type_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'paid' => $this->paid,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'purchase_order_code', $this->purchase_order_code])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
