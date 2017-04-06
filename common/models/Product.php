<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property integer $product_category_id
 * @property string $product_name
 * @property string $product_code
 * @property string $unit_of_measure
 * @property integer $status
 * @property integer $quantity
 * @property integer $cost_price
 * @property integer $gst_price
 * @property integer $selling_price
 * @property integer $reorder_level
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property ProductCategory $productCategory
 * @property Supplier $supplier
 * @property StorageLocations $storageLocation
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'storage_location_id', 'product_category_id', 'product_code', 'product_name', 'quantity', 'cost_price', 'gst_price', 'selling_price', 'unit_of_measure', 'reorder_level', 'status'], 'required', 'message' => 'Fill up all the required fields.'],
            [['product_category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_name'], 'string', 'max' => 150],
            [['product_name'], 'unique', 'message' => 'Product name already exist.'],
            [['product_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['product_category_id' => 'id']],
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
            'product_category_id' => 'Product Category ID',
            'product_name' => 'Product Name',
            'product_code' => 'Product Code',
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
    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category_id']);
    }

    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    public function getStorageLocation()
    {
        return $this->hasOne(StorageLocations::className(), ['id' => 'storage_location_id']);
    }

    // Active Record joining relations
    public function getProductById($id)
    {
        $rows = new Query();

        $result = $rows->select(['product.*', 'product_category.name', 'supplier.name as supplierName', 'storage_location.rack as storagelocationName' ])
            ->from('product')
            ->leftJoin('product_category', 'product.product_category_id = product_category.id')
            ->leftJoin('supplier', 'product.supplier_id = supplier.id')
            ->leftJoin('storage_location', 'product.storage_location_id = storage_location.id')
            ->where(['product.id' => $id])
            ->one();

        return $result;
    }

    // Active Record joining relations
    public function getProductList()
    {
        $rows = new Query();

        $result = $rows->select(['product.*', 'product_category.name', 'supplier.name as supplierName', 'storage_location.rack as storagelocationName' ])
            ->from('product')
            ->leftJoin('product_category', 'product.product_category_id = product_category.id')
            ->leftJoin('supplier', 'product.supplier_id = supplier.id')
            ->leftJoin('storage_location', 'product.storage_location_id = storage_location.id')
            ->all();

        return $result;
    }
}
