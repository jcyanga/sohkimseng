<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Quotation;

/**
 * SearchQuotation represents the model behind the search form about `common\models\Quotation`.
 */
class SearchQuotation extends Quotation
{
    public $company_name;
    public $fullname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'customer_id', 'status', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['quotation_code', 'date_issue', 'remarks', 'created_at', 'updated_at', 'company_name', 'fullname'], 'safe'],
            [['grand_total', 'net'], 'number'],
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
        $query = Quotation::find()->where(['quotation.status' => 1])->andWhere('quotation.condition <= 1');
        $query->joinWith(['user']);    
        $query->joinWith(['customer']);   
        // $query->joinWith(['payment_type']);    
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
            'date_issue' => $this->date_issue,
            'grand_total' => $this->grand_total,
            'net' => $this->net,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'quotation_code', $this->quotation_code])
            ->andFilterWhere(['like', 'customer.company_name', $this->company_name])
            ->andFilterWhere(['like', 'customer.fullname', $this->fullname]);

        return $dataProvider;
    }
}
