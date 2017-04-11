<?php

namespace common\models;

use Yii;

use common\models\Parts;
use common\models\Service;
use common\models\PartsInventory;

use yii\db\Query;

use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "quotation".
 *
 * @property integer $id
 * @property string $quotation_code
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
 * @property integer $deleted
 *
 * @property Customer $customer
 * @property User $user
 * @property PaymentType $paymentType
 * @property QuotationDetail[] $quotationDetails
 */
class Quotation extends \yii\db\ActiveRecord
{
    public $service_category;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quotation_code', 'user_id', 'customer_id', 'grand_total', 'gst', 'net', 'remarks'], 'required', 'message' => 'Fill up the required fields.'],
            [['customer_id', 'user_id'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number', 'message' => 'Invalid option selected'],
            [['user_id', 'customer_id', 'status', 'created_by', 'updated_by', 'deleted'], 'integer'],
            [['date_issue', 'created_at', 'updated_at'], 'safe'],
            [['grand_total', 'gst', 'net'], 'number'],
            [['remarks'], 'string'],
            [['quotation_code'], 'string', 'max' => 100],
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
            'user_id' => 'User ID',
            'customer_id' => 'Customer ID',
            'date_issue' => 'Date Issue',
            'grand_total' => 'Grand Total',
            'gst' => 'GST',
            'net' => 'Nett Total',
            'remarks' => 'Remarks',
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
    // public function getPaymentType()
    // {
    //     return $this->hasOne(PaymentType::className(), ['id' => 'payment_type_id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuotationDetails()
    {
        return $this->hasMany(QuotationDetail::className(), ['quotation_id' => 'id']);
    }

    // get quotation Id
    public function getQuotationId()
    {
        $query = new Query();

        $result = $query->select(['Max(id) as quotation_id'])
                        ->from('quotation')
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['quotation_id'] + 1;
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
                            ->where(['service.status' => 1])
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
                            ->andWhere(['service.status' => 1])
                            ->one();
               
        return $result;
    }

    // get quotation information for preview
    public function getQuotationByIdForPreview($id)
    {
        $query = new Query();

        $result = $query->select([ 'quotation.id', 'quotation.quotation_code', 'quotation.customer_id', 'customer.fullname as customerName', 'quotation.user_id', 'user.fullname as salesPerson', 'quotation.date_issue', 'quotation.grand_total', 'quotation.gst', 'quotation.net', 'quotation.remarks', 'quotation.status', 'quotation.created_at', 'quotation.created_by', 'quotation.invoice_created', 'payment_type.name as paymenttypeName', 'customer.type', 'customer.nric', 'customer.company_name', 'customer.uen_no', 'customer.address', 'customer.shipping_address', 'customer.email', 'customer.phone_number', 'customer.mobile_number', 'customer.fax_number', 'quotation.discount_amount', 'quotation.discount_remarks', 'quotation.condition', 'quotation.payment_type_id', 'quotation.gst_value' ])
                    ->from('quotation')
                    ->leftJoin('customer', 'quotation.customer_id = customer.id')
                    ->leftJoin('user', 'quotation.user_id = user.id')
                    ->leftJoin('payment_type', 'quotation.payment_type_id = payment_type.id')
                    ->where(['quotation.id' => $id, 'quotation.status' => 1])
                    ->one();

        return $result;

    }

    public function getQuotationServiceForPreview($id)
    {
        $query = new Query();

        $result = $query->select([ 'quotation_detail.id', 'quotation_detail.description', 'service.service_name as name', 'quotation_detail.quantity', 'quotation_detail.unit_price', 'quotation_detail.sub_total', 'quotation_detail.type', 'quotation_detail.status' ])
                    ->from('quotation_detail')
                    ->leftJoin('service', 'quotation_detail.description = service.id')
                    ->where(['quotation_detail.quotation_id' => $id])
                    ->andWhere(['quotation_detail.type' => 0])
                    ->andWhere(['quotation_detail.status' => 1])
                    ->all();

        return $result;

    }

    public function getQuotationPartsForPreview($id)
    {
        $query = new Query();

        $result = $query->select([ 'quotation_detail.id', 'quotation_detail.description', 'parts.parts_name as name', 'parts.unit_of_measure', 'parts.parts_code', 'quotation_detail.quantity', 'quotation_detail.unit_price', 'quotation_detail.sub_total', 'quotation_detail.type', 'quotation_detail.status' ])
                    ->from('quotation_detail')
                    ->leftJoin('parts', 'quotation_detail.description = parts.id')
                    ->where(['quotation_detail.quotation_id' => 1])
                    ->andWhere(['quotation_detail.type' => 1])
                    ->andWhere(['quotation_detail.status' => 1])
                    ->all();

        return $result;
    }

    // get last invoice id
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

}
