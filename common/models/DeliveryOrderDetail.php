<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "delivery_order_detail".
 *
 * @property integer $id
 * @property integer $delivery_order_id
 * @property integer $description
 * @property integer $quantity
 * @property double $unit_price
 * @property double $sub_total
 * @property integer $type
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $deleted
 *
 * @property DeliveryOrder $deliveryOrder
 */
class DeliveryOrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_order_id', 'description', 'quantity', 'unit_price', 'sub_total', 'type'], 'required'],
            [['delivery_order_id', 'description', 'quantity', 'type', 'status', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['unit_price', 'sub_total'], 'number'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted'], 'safe'],
            [['delivery_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveryOrder::className(), 'targetAttribute' => ['delivery_order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_order_id' => 'Delivery Order ID',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'sub_total' => 'Sub Total',
            'type' => 'Type',
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
    public function getDeliveryOrder()
    {
        return $this->hasOne(DeliveryOrder::className(), ['id' => 'delivery_order_id']);
    }
}
