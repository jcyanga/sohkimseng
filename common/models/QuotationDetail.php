<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quotation_detail".
 *
 * @property integer $id
 * @property integer $quotation_id
 * @property integer $description
 * @property integer $quantity
 * @property double $unit_price
 * @property double $sub_total
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $deleted
 *
 * @property Quotation $quotation
 */
class QuotationDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_id', 'description', 'quantity', 'unit_price', 'sub_total', 'type' ], 'required'],
            [['quotation_id', 'description', 'quantity', 'status', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['unit_price', 'sub_total'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['quotation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quotation::className(), 'targetAttribute' => ['quotation_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_id' => 'Quotation ID',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'sub_total' => 'Sub Total',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotation()
    {
        return $this->hasOne(Quotation::className(), ['id' => 'quotation_id']);
    }
}
