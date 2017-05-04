<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_order_detail".
 *
 * @property integer $id
 * @property integer $purchase_order_id
 * @property integer $parts_products
 * @property integer $quantity
 * @property double $unit_price
 * @property double $sub_total
 * @property integer $type
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property integer $deleted
 *
 * @property PurchaseOrder $purchaseOrder
 */
class PurchaseOrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_order_id', 'parts_products', 'quantity', 'type', 'status', 'created_by', 'deleted'], 'integer'],
            [['parts_products', 'quantity', 'unit_price', 'sub_total', 'type', 'status', 'created_at', 'created_by', 'deleted'], 'required'],
            [['unit_price', 'sub_total'], 'number'],
            [['created_at'], 'safe'],
            [['purchase_order_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseOrder::className(), 'targetAttribute' => ['purchase_order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_order_id' => 'Purchase Order ID',
            'parts_products' => 'Parts Products',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'sub_total' => 'Sub Total',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::className(), ['id' => 'purchase_order_id']);
    }
}
