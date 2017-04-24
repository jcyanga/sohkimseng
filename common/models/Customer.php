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
            [['type', 'address', 'shipping_address', 'email', 'phone_number', 'mobile_number'], 'required', 'message' => 'Fill up all the required fields.'],
            [['address'], 'string'],
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
    
}
