<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DeliveryOrder;

/**
 * SearchDeliveryOrder represents the model behind the search form about `common\models\DeliveryOrder`.
 */
class SearchDeliveryOrder extends DeliveryOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'customer_id', 'payment_type_id', 'status', 'created_by', 'updated_by', 'paid', 'deleted', 'condition', 'action_by'], 'integer'],
            [['delivery_order_code', 'invoice_no', 'date_issue', 'remarks', 'discount_remarks', 'created_at', 'updated_at'], 'safe'],
            [['grand_total', 'gst', 'gst_value', 'net', 'discount_amount'], 'number'],
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
        $query = DeliveryOrder::find()->where(['status' => 1]);

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
            'customer_id' => $this->customer_id,
            'date_issue' => $this->date_issue,
            'grand_total' => $this->grand_total,
            'gst' => $this->gst,
            'gst_value' => $this->gst_value,
            'net' => $this->net,
            'payment_type_id' => $this->payment_type_id,
            'discount_amount' => $this->discount_amount,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'paid' => $this->paid,
            'deleted' => $this->deleted,
            'condition' => $this->condition,
            'action_by' => $this->action_by,
        ]);

        $query->andFilterWhere(['like', 'delivery_order_code', $this->delivery_order_code])
            ->andFilterWhere(['like', 'invoice_no', $this->invoice_no])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'discount_remarks', $this->discount_remarks]);

        return $dataProvider;
    }
}
