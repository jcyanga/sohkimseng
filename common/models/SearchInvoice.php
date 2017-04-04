<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Invoice;

/**
 * SearchInvoice represents the model behind the search form about `common\models\Invoice`.
 */
class SearchInvoice extends Invoice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'customer_id', 'status', 'created_by', 'updated_by', 'do', 'paid', 'deleted'], 'integer'],
            [['quotation_code', 'invoice_no', 'date_issue', 'remarks', 'created_at', 'updated_at'], 'safe'],
            [['grand_total', 'gst', 'net'], 'number'],
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
        $query = Invoice::find();

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
            'net' => $this->net,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'do' => $this->do,
            'paid' => $this->paid,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'quotation_code', $this->quotation_code])
            ->andFilterWhere(['like', 'invoice_no', $this->invoice_no])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
