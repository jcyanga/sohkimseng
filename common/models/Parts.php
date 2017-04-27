<?php

namespace common\models;

use Yii;
use yii\db\Query;
/**
 * This is the model class for table "parts".
 *
 * @property integer $id
 * @property integer $parts_category_id
 * @property string $parts_code
 * @property string $parts_name
 * @property string $unit_of_measure
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $supplier_id
 * @property integer $quantity
 * @property integer $cost_price
 * @property integer $gst_price
 * @property integer $selling_price
 * @property integer $reorder_level
 *
 * @property Supplier $supplier
 * @property StorageLocations $storageLocation
 */
class Parts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'storage_location_id', 'parts_name', 'parts_code', 'quantity', 'unit_of_measure', 'cost_price', 'gst_price', 'selling_price', 'reorder_level', 'status'], 'required', 'message' => 'Fill up all the required fields.'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['parts_name'], 'string', 'max' => 150],
            [['parts_name'], 'unique', 'message' => 'Auto-Parts name already exist.'],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
            [['storage_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => StorageLocations::className(), 'targetAttribute' => ['storage_location_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parts_code' => 'Parts Code',
            'parts_name' => 'Name',
            'unit_of_measure' => 'Unit of Measure',
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

    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    public function getStorageLocation()
    {
        return $this->hasOne(StorageLocations::className(), ['id' => 'storage_location_id']);
    }

    // Active Record joining relations
    public function getPartsById($id)
    {
        $rows = new Query();

        $result = $rows->select(['parts.*', 'supplier.name as supplierName', 'storage_location.rack as storagelocationName' ])
            ->from('parts')
            ->leftJoin('supplier', 'parts.supplier_id = supplier.id')
            ->leftJoin('storage_location', 'parts.storage_location_id = storage_location.id')
            ->where(['parts.id' => $id])
            ->andWhere(['parts.status' => 1])
            ->one();

        return $result;
    }

    public function getPartsCategoryByPartsId($id)
    {
        $rows = new Query();

        $result = $rows->select(['parts_type.id', 'parts_type.parts_category_id', 'parts_category.name' ])
            ->from('parts_type')
            ->leftJoin('parts_category', 'parts_type.parts_category_id = parts_category.id')
            ->where(['parts_type.parts_id' => $id])
            ->andWhere(['parts_type.status' => 1])
            ->all();

        return $result;
    }

    // Active Record joining relations
    public function getPartsList()
    {
        $rows = new Query();

        $result = $rows->select(['parts.*', 'parts_category.name', 'supplier.name as supplierName', 'storage_location.rack as storagelocationName' ])
            ->from('parts')
            ->leftJoin('supplier', 'parts.supplier_id = supplier.id')
            ->leftJoin('parts_category', 'parts.parts_category_id = parts_category.id')
            ->leftJoin('storage_location', 'parts.storage_location_id = storage_location.id')
            ->where(['parts.status' => 1])
            ->all();

        return $result;
    }

    //  get parts category
    public function getPartsCategory($partsId)
    {
        $rows = new Query();

        $result = $rows->select(['parts_type.id', 'parts_type.parts_category_id', 'parts_category.name' ])
            ->from('parts_type')
            ->leftJoin('parts_category', 'parts_type.parts_category_id = parts_category.id')
            ->where(['parts_type.parts_id' => $partsId])
            ->all();

        return $result;
    }

}
