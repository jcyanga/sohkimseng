<?php

namespace common\models;

use Yii;

use yii\db\Query;

/**
 * This is the model class for table "product_inventory".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $quantity
 * @property double $price
 * @property integer $status
 * @property string $datetime_imported
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Product $product
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
            [['product_id', 'old_quantity', 'new_quantity', 'status'], 'required', 'message' => 'Fill up all the required fields.'],
            [['product_id', 'old_quantity', 'new_quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['datetime_imported', 'created_at', 'updated_at'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
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
            'old_quantity' => 'Old Quantity',
            'new_quantity' => 'New Quantity',
            'status' => 'Status',
            'datetime_imported' => 'Date Time Imported',
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

    // Active Record joining relations
    public function getProductInventoryList()
    {
        $rows = new Query();

        $result = $rows->select(['product_inventory.*', 'product.product_name'])
            ->from('product_inventory')
            ->leftJoin('product', 'product_inventory.product_id = product.id')
            ->all();

        return $result;
    }
}
