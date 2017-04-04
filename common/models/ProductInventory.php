<?php

namespace common\models;

use Yii;

use yii\db\Query;

/**
 * This is the model class for table "product_inventory".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $supplier_id
 * @property integer $quantity
 * @property double $price
 * @property integer $status
 * @property string $date_imported
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Product $product
 * @property Supplier $supplier
 */
class ProductInventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'supplier_id', 'quantity', 'price', 'status'], 'required', 'message' => 'Fill up all the required fields.'],
            [['product_id', 'supplier_id', 'quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['price'], 'number'],
            [['date_imported', 'created_at', 'updated_at'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'supplier_id' => 'Supplier ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'status' => 'Status',
            'date_imported' => 'Date Imported',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    // Active Record joining relations
    public function getProductInventoryList()
    {
        $rows = new Query();

        $result = $rows->select(['product_inventory.*', 'supplier.name', 'product.product_name'])
            ->from('product_inventory')
            ->leftJoin('supplier', 'product_inventory.supplier_id = supplier.id')
            ->leftJoin('product', 'product_inventory.product_id = product.id')
            ->all();

        return $result;
    }
}
