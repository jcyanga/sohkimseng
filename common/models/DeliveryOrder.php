<?php

namespace common\models;

use Yii;

use yii\db\Query;

/**
 * This is the model class for table "delivery_order".
 *
 * @property integer $id
 * @property string $delivery_order_code
 * @property string $invoice_no
 * @property integer $user_id
 * @property integer $customer_id
 * @property string $date_issue
 * @property double $grand_total
 * @property double $gst
 * @property double $gst_value
 * @property double $net
 * @property string $remarks
 * @property integer $payment_type_id
 * @property double $discount_amount
 * @property string $discount_remarks
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $paid
 * @property integer $deleted
 * @property integer $condition
 * @property integer $action_by
 *
 * @property Customer $customer
 * @property User $user
 */
class DeliveryOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_order_code', 'user_id', 'customer_id', 'grand_total', 'gst', 'net', 'remarks'], 'required', 'message' => 'Fill up the required fields.'],
            [['customer_id', 'user_id'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'message' => 'Invalid option selected'],
            [['user_id', 'customer_id', 'status', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['date_issue', 'created_at', 'updated_at'], 'safe'],
            [['grand_total', 'gst', 'gst_value', 'net', 'discount_amount'], 'number'],
            [['remarks', 'discount_remarks'], 'string'],
            [['delivery_order_code'], 'string', 'max' => 100],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
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
            'delivery_order_code' => 'Delivery Order Code',
            'invoice_no' => 'Invoice No',
            'user_id' => 'User ID',
            'customer_id' => 'Customer ID',
            'date_issue' => 'Date Issue',
            'grand_total' => 'Grand Total',
            'gst' => 'Gst',
            'gst_value' => 'Gst Value',
            'net' => 'Net',
            'remarks' => 'Remarks',
            'payment_type_id' => 'Payment Type ID',
            'discount_amount' => 'Discount Amount',
            'discount_remarks' => 'Discount Remarks',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'paid' => 'Paid',
            'deleted' => 'Deleted',
            'condition' => 'Condition',
            'action_by' => 'Action By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    // get delivery order Id
    public function getDeliveryOrderId()
    {
        $query = new Query();

        $result = $query->select(['Max(id) as delivery_order_id'])
                        ->from('delivery_order')
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['delivery_order_id'] + 1;
        }else {
            return 0;
        }      
    }

    // get parts 
    public function getPartsList()
    {
        $query = new Query();

        $result = $query->select(['parts.id', 'parts.parts_code', 'parts.parts_name', 'parts.quantity', 'parts.cost_price', 'parts.gst_price', 'parts.selling_price', 'parts.reorder_level', 'parts.unit_of_measure', 'parts_category.name', 'supplier.name as supplierName', 'storage_location.rack', 'storage_location.bay', 'storage_location.level', 'storage_location.position' ])
                        ->from('parts')
                        ->leftJoin('parts_category', 'parts.parts_category_id = parts_category.id')
                        ->leftJoin('supplier', 'parts.supplier_id = supplier.id')
                        ->leftJoin('storage_location', 'parts.storage_location_id = storage_location.id')
                        ->where(['parts.status' => 1])
                        ->all();

        return $result;
    }

    public function getPartsById($id)
    {
        $query = new Query();

        $result = $query->select(['parts.id', 'parts.parts_code', 'parts.parts_name', 'parts.quantity', 'parts.cost_price', 'parts.gst_price', 'parts.selling_price', 'parts.reorder_level', 'parts.unit_of_measure', 'parts_category.name', 'supplier.name as supplierName', 'storage_location.rack', 'storage_location.bay', 'storage_location.level', 'storage_location.position' ])
                        ->from('parts')
                        ->leftJoin('parts_category', 'parts.parts_category_id = parts_category.id')
                        ->leftJoin('supplier', 'parts.supplier_id = supplier.id')
                        ->leftJoin('storage_location', 'parts.storage_location_id = storage_location.id')
                        ->where(['parts.id' => $id])
                        ->andWhere(['parts.status' => 1])
                        ->one();
               
        return $result;
    }

    // get services 
    public function getServicesList()
    {
        $query = new Query();

        $result = $query->select(['service.*', 'service_category.name'])
                            ->from('service')
                            ->leftJoin('service_category', 'service.service_category_id = service_category.id')
                            ->all();
               
        return $result;
    }

    public function getServicesById($id)
    {
        $query = new Query();

        $result = $query->select(['service.*', 'service_category.name'])
                            ->from('service')
                            ->leftJoin('service_category', 'service.service_category_id = service_category.id')
                            ->where(['service.id' => $id])
                            ->one();
               
        return $result;
    }

    // get delivery order information for preview
    public function getDeliveryOrderByIdForPreview($id)
    {
        $query = new Query();

        $result = $query->select([ 'delivery_order.id', 'delivery_order.invoice_no', 'delivery_order.delivery_order_code', 'delivery_order.customer_id', 'customer.fullname as customerName', 'delivery_order.user_id', 'user.fullname as salesPerson', 'delivery_order.date_issue', 'delivery_order.grand_total', 'delivery_order.gst', 'delivery_order.net', 'delivery_order.remarks', 'delivery_order.status', 'delivery_order.created_at', 'delivery_order.created_by', 'payment_type.name as paymenttypeName', 'customer.type', 'customer.nric', 'customer.company_name', 'customer.uen_no', 'customer.address', 'customer.shipping_address', 'customer.email', 'customer.phone_number', 'customer.mobile_number', 'customer.fax_number', 'delivery_order.discount_amount', 'delivery_order.discount_remarks', 'delivery_order.condition', 'delivery_order.payment_type_id', 'delivery_order.gst_value', 'delivery_order.paid' ])
                    ->from('delivery_order')
                    ->leftJoin('customer', 'delivery_order.customer_id = customer.id')
                    ->leftJoin('user', 'delivery_order.user_id = user.id')
                    ->leftJoin('payment_type', 'delivery_order.payment_type_id = payment_type.id')
                    ->where(['delivery_order.id' => $id, 'delivery_order.status' => 1])
                    ->one();

        return $result;

    }

    public function getDeliveryOrderServiceForPreview($id)
    {
        $query = new Query();

        $result = $query->select([ 'delivery_order_detail.id', 'delivery_order_detail.description', 'service.service_name as name', 'delivery_order_detail.quantity', 'delivery_order_detail.unit_price', 'delivery_order_detail.sub_total', 'delivery_order_detail.type', 'delivery_order_detail.status' ])
                    ->from('delivery_order_detail')
                    ->leftJoin('service', 'delivery_order_detail.description = service.id')
                    ->where(['delivery_order_detail.delivery_order_id' => $id])
                    ->andWhere(['delivery_order_detail.type' => 0])
                    ->andWhere(['delivery_order_detail.status' => 1])
                    ->all();

        return $result;

    }

    public function getDeliveryOrderPartsForPreview($id)
    {
        $query = new Query();

        $result = $query->select([ 'delivery_order_detail.id', 'delivery_order_detail.description', 'parts.parts_name as name', 'parts.unit_of_measure', 'parts.parts_code', 'delivery_order_detail.quantity', 'delivery_order_detail.unit_price', 'delivery_order_detail.sub_total', 'delivery_order_detail.type', 'delivery_order_detail.status' ])
                    ->from('delivery_order_detail')
                    ->leftJoin('parts', 'delivery_order_detail.description = parts.id')
                    ->where(['delivery_order_detail.delivery_order_id' => $id])
                    ->andWhere(['delivery_order_detail.type' => 1])
                    ->andWhere(['delivery_order_detail.status' => 1])
                    ->all();

        return $result;
    }


}
