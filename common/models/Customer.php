<?php

namespace common\models;

use Yii;

use yii\db\Query;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $fullname
 * @property string $address
 * @property string $race_id
 * @property string $email
 * @property string $phone_number
 * @property string $mobile_number
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $type
 * @property string $shipping_address
 * @property string $uen_no
 * @property string $nric
 * @property string $fax_number
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'email', 'phone_number', 'mobile_number'], 'required', 'message' => 'Fill up all the required fields.'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['race_id', 'created_at', 'updated_at'], 'safe'],
            [['fullname'], 'string', 'max' => 100],
            [['email', 'phone_number', 'mobile_number'], 'string', 'max' => 50],
            [['fullname'], 'unique', 'message' => 'Name already exist.'],
            [['company_name'], 'unique', 'message' => 'Company name already exist.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'address' => 'Address',
            'race_id' => 'Race',
            'email' => 'Email',
            'phone_number' => 'Phone Number',
            'mobile_number' => 'Mobile Number',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    // get customer with race info by id
    public function getCustomers($id)
    {
        $query = new Query();

        $result = $query->select(['customer.*', 'race.name'])
                            ->from('customer')
                            ->leftJoin('race', 'customer.race_id = race.id')
                            ->where(['customer.id' => $id])
                            ->one();

        return $result;
        
    }
    
    // get Last Id
    public function getLastId()
    {
        $query = new Query();

        $result = $query->select(['Max(id) as customerId'])
                        ->from('customer')
                        ->where(['status' => 1])
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['customerId'] + 1;
        }else {
            return 0;
        }      
    }

    // get company contactperson and address
    public function getCompanyContactpersonAddress($customer_id)
    {
        $query = new Query();

        $result = $query->select(['customer_contactperson_address.*'])
                            ->from('customer_contactperson_address')
                            ->where(['customer_contactperson_address.customer_id' => $customer_id])
                            ->all();

        return $result;
    }

    // get Last Customer Company Info Id
    public function getLastCompanyInformationId()
    {
        $query = new Query();

        $result = $query->select(['Max(id) as companyinformationId'])
                        ->from('customer_contactperson_address')
                        ->where(['status' => 1])
                        ->one();
               
        if( count($result) > 0 ) {
            return $result['companyinformationId'] + 1;
        }else {
            return 0;
        }      
    }

}
