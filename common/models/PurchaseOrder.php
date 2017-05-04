<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "purchase_order".
 *
 * @property integer $id
 * @property string $purchase_order_code
 * @property integer $user_id
 * @property integer $supplier_id
 * @property string $date_issue
 * @property double $grand_total
 * @property double $gst
 * @property double $gst_value
 * @property double $net
 * @property string $remarks
 * @property integer $payment_type_id
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property integer $paid
 * @property integer $deleted
 *
 * @property Supplier $supplier
 * @property User $user
 * @property PurchaseOrderDetail[] $purchaseOrderDetails
 */
class PurchaseOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'supplier_id', 'payment_type_id', 'status', 'created_by', 'paid', 'deleted'], 'integer'],
            [['date_issue', 'created_at'], 'safe'],
            [['grand_total', 'gst', 'gst_value', 'net'], 'number'],
            [['remarks'], 'string'],
            [['purchase_order_code'], 'string', 'max' => 100],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'purchase_order_code' => 'Purchase Order Code',
            'user_id' => 'User ID',
            'supplier_id' => 'Supplier ID',
            'date_issue' => 'Date Issue',
            'grand_total' => 'Grand Total',
            'gst' => 'Gst',
            'gst_value' => 'Gst Value',
            'net' => 'Net',
            'remarks' => 'Remarks',
            'payment_type_id' => 'Payment Type ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'paid' => 'Paid',
            'deleted' => 'Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseOrderDetails()
    {
        return $this->hasMany(PurchaseOrderDetail::className(), ['purchase_order_id' => 'id']);
    }
}
