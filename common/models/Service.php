<?php

namespace common\models;

use Yii;
use yii\db\Query;
/**
 * This is the model class for table "service".
 *
 * @property integer $id
 * @property integer $service_category_id
 * @property string $service_name
 * @property string $description
 * @property double $price
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property ServiceCategory $serviceCategory
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_category_id', 'service_name', 'description', 'price', 'status'], 'required', 'message' => 'Fill up the required fields.'],
            [['service_category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['service_name'], 'string', 'max' => 150],
            [['service_name'], 'unique', 'message' => 'Service name already exist.'],
            [['service_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceCategory::className(), 'targetAttribute' => ['service_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_category_id' => 'Service Category ID',
            'service_name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
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
    public function getServiceCategory()
    {
        return $this->hasOne(ServiceCategory::className(), ['id' => 'service_category_id']);
    }

    // Active Record joining relations
    public function getServiceById($id)
    {
        $rows = new Query();

        $result = $rows->select(['service.*', 'service_category.name'])
            ->from('service')
            ->leftJoin('service_category', 'service.service_category_id = service_category.id')
            ->where(['service.id' => $id])
            ->one();

        return $result;
    }

    // Active Record joining relations
    public function getServiceList()
    {
        $rows = new Query();

        $result = $rows->select(['service.*', 'service_category.name'])
            ->from('service')
            ->leftJoin('service_category', 'service.service_category_id = service_category.id')
            ->where(['service.status' => 1])
            ->all();

        return $result;
    }
}
