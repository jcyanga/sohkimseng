<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property integer $id
 * @property string $supplier_code
 * @property string $name
 * @property string $address
 * @property string $contact_number
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_code', 'name', 'address', 'contact_number', 'status'], 'required', 'message' => 'Fill up all the required fields.'],
            [['address'], 'string'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['supplier_code'], 'string', 'max' => 150],
            [['name'], 'string', 'max' => 100],
            [['contact_number'], 'string', 'max' => 50],
            [['supplier_code'], 'unique', 'message' => 'Supplier code already exist.'],
            [['name'], 'unique', 'message' => 'Supplier name already exist.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_code' => 'Supplier Code',
            'name' => 'Name',
            'address' => 'Address',
            'contact_number' => 'Contact Number',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
