<?php

namespace common\models;

use Yii;

use yii\db\Query;

/**
 * This is the model class for table "parts_inventory".
 *
 * @property integer $id
 * @property integer $parts_id
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
 * @property Parts $parts
 * @property Supplier $supplier
 */
class PartsInventory extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parts_inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parts_id', 'old_quantity', 'new_quantity', 'type'], 'required', 'message' => 'Fill up all the required fields.'],
            [['parts_id', 'old_quantity', 'new_quantity', 'status', 'created_by', 'updated_by'], 'integer'],
            [['datetime_imported', 'created_at', 'updated_at'], 'safe'],
            [['parts_id'], 'exist', 'skipOnError' => true, 'targetClass' => Parts::className(), 'targetAttribute' => ['parts_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parts_id' => 'Parts ID',
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
    public function getParts()
    {
        return $this->hasOne(Parts::className(), ['id' => 'parts_id']);
    }

    // Active Record joining relations
    public function getPartsInventoryList()
    {
        $rows = new Query();

        $result = $rows->select(['parts_inventory.*', 'parts.parts_name', 'parts_inventory.old_quantity' , 'parts_inventory.new_quantity', 'parts_inventory.type' ])
            ->from('parts_inventory')
            ->leftJoin('parts', 'parts_inventory.parts_id = parts.id')
            ->all();

        return $result;
    }
}
