<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment_type".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $interest
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Invoice[] $invoices
 * @property Quotation[] $quotations
 */
class PaymentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'interest', 'status'], 'required', 'message' => 'Fill-up required fields.'],
            [['description'], 'string'],
            [['interest', 'status', 'created_by', 'updated_by'], 'integer'],
            [[ 'created_at', 'created_by', 'updated_at', 'updated_by'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['name'], 'unique', 'message' => 'Payment type name already exist.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'interest' => 'Interest',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices()
    {
        return $this->hasMany(Invoice::className(), ['payment_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotations()
    {
        return $this->hasMany(Quotation::className(), ['payment_type_id' => 'id']);
    }
}
