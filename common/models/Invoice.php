<?php

namespace common\models;

use Yii;

use yii\db\Query;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property string $quotation_code
 * @property string $invoice_no
 * @property integer $user_id
 * @property integer $customer_id
 * @property string $date_issue
 * @property double $grand_total
 * @property double $gst
 * @property double $net
 * @property string $remarks
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $do
 * @property integer $paid
 * @property integer $deleted
 *
 * @property Customer $customer
 * @property User $user
 * @property InvoiceDetail[] $invoiceDetails
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_no', 'user_id', 'customer_id', 'grand_total', 'gst', 'net', 'remarks'], 'required', 'message' => 'Fill up the required fields.'],
            [['customer_id', 'user_id'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'message' => 'Invalid option selected'],
            [['user_id', 'customer_id', 'status', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['date_issue', 'created_at', 'updated_at'], 'safe'],
            [['grand_total', 'gst', 'net'], 'number'],
            [['remarks'], 'string'],
            [['invoice_no'], 'string', 'max' => 100],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['payment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentType::className(), 'targetAttribute' => ['payment_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quotation_code' => 'Quotation Code',
            'invoice_no' => 'Invoice No',
            'user_id' => 'User ID',
            'customer_id' => 'Customer ID',
            'date_issue' => 'Date Issue',
            'grand_total' => 'Grand Total',
            'gst' => 'GST',
            'net' => 'Net',
            'remarks' => 'Remarks',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'do' => 'Do',
            'paid' => 'Paid',
            'deleted' => 'Deleted',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::className(), ['invoice_id' => 'id']);
    }

    // get invoice Id
    public function getInvoiceId()
    {
        $query = new Query();

        $result = $query->select(['Max(id) as invoice_id'])
                        ->from('invoice')
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['invoice_id'] + 1;
        }else {
            return 0;
        }      
    }

    // get parts 
    public function getPartsList()
    {
        $query = new Query();

        $result = $query->select(['parts.id', 'parts.parts_code', 'parts.parts_name', 'parts.quantity', 'parts.cost_price', 'parts.gst_price', 'parts.selling_price', 'parts.reorder_level', 'parts.unit_of_measure', 'supplier.name as supplierName', 'storage_location.rack', 'storage_location.bay', 'storage_location.level', 'storage_location.position' ])
                        ->from('parts')
                        ->leftJoin('supplier', 'parts.supplier_id = supplier.id')
                        ->leftJoin('storage_location', 'parts.storage_location_id = storage_location.id')
                        ->where(['parts.status' => 1])
                        ->all();

        return $result;
    }

    public function getPartsById($id)
    {
        $query = new Query();

        $result = $query->select(['parts.id', 'parts.parts_code', 'parts.parts_name', 'parts.quantity', 'parts.cost_price', 'parts.gst_price', 'parts.selling_price', 'parts.reorder_level', 'parts.unit_of_measure', 'supplier.name as supplierName', 'storage_location.rack', 'storage_location.bay', 'storage_location.level', 'storage_location.position' ])
                        ->from('parts')
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

    // get invoice information for preview
    public function getInvoiceByIdForPreview($id)
    {
        $query = new Query();

        $result = $query->select([ 'invoice.id', 'invoice.invoice_no', 'invoice.quotation_code', 'invoice.customer_id', 'customer.fullname as customerName', 'invoice.user_id', 'user.fullname as salesPerson', 'invoice.date_issue', 'invoice.grand_total', 'invoice.gst', 'invoice.net', 'invoice.remarks', 'invoice.status', 'invoice.created_at', 'invoice.created_by', 'payment_type.name as paymenttypeName', 'customer.type', 'customer.nric', 'customer.company_name', 'customer.uen_no', 'customer.address', 'customer.shipping_address', 'customer.email', 'customer.phone_number', 'customer.mobile_number', 'customer.fax_number', 'invoice.discount_amount', 'invoice.discount_remarks', 'invoice.condition', 'invoice.payment_type_id', 'invoice.gst_value', 'invoice.paid', 'invoice.do' ])
                    ->from('invoice')
                    ->leftJoin('customer', 'invoice.customer_id = customer.id')
                    ->leftJoin('user', 'invoice.user_id = user.id')
                    ->leftJoin('payment_type', 'invoice.payment_type_id = payment_type.id')
                    ->where(['invoice.id' => $id, 'invoice.status' => 1])
                    ->one();

        return $result;

    }

    public function getInvoiceServiceForPreview($id)
    {
        $query = new Query();

        $result = $query->select([ 'invoice_detail.id', 'invoice_detail.description', 'service.service_name as name', 'invoice_detail.quantity', 'invoice_detail.unit_price', 'invoice_detail.sub_total', 'invoice_detail.type', 'invoice_detail.status' ])
                    ->from('invoice_detail')
                    ->leftJoin('service', 'invoice_detail.description = service.id')
                    ->where(['invoice_detail.invoice_id' => $id])
                    ->andWhere(['invoice_detail.type' => 0])
                    ->andWhere(['invoice_detail.status' => 1])
                    ->all();

        return $result;

    }

    public function getInvoicePartsForPreview($id)
    {
        $query = new Query();

        $result = $query->select([ 'invoice_detail.id', 'invoice_detail.description', 'parts.parts_name as name', 'parts.unit_of_measure', 'parts.parts_code', 'invoice_detail.quantity', 'invoice_detail.unit_price', 'invoice_detail.sub_total', 'invoice_detail.type', 'invoice_detail.status' ])
                    ->from('invoice_detail')
                    ->leftJoin('parts', 'invoice_detail.description = parts.id')
                    ->where(['invoice_detail.invoice_id' => $id])
                    ->andWhere(['invoice_detail.type' => 1])
                    ->andWhere(['invoice_detail.status' => 1])
                    ->all();

        return $result;
    }

    // get customer list
    public function getCustomerList()
    {
        $result = Yii::$app->db->createCommand('
                            SELECT customer.id as id, CONCAT(customer.company_name, " / ", customer.location) as customerInfo FROM customer WHERE customer.type = 1 AND customer.status = 1 

                            UNION ALL 

                            SELECT customer.id as id, CONCAT(customer.fullname, " / ", customer.location) as customerInfo FROM customer WHERE customer.type = 2 AND customer.status = 1 

                        ')->queryAll();

        return $result;
        
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
}
