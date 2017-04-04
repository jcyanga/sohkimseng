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
 * @property string $description
 * @property string $unit_of_measure
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property PartsCategory $partsCategory
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
            [['parts_category_id', 'parts_name', 'parts_code', 'description', 'unit_of_measure', 'status'], 'required', 'message' => 'Fill up all the required fields.'],
            [['parts_category_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['parts_name'], 'string', 'max' => 150],
            [['parts_name'], 'unique', 'message' => 'Auto-Parts name already exist.'],
            [['parts_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartsCategory::className(), 'targetAttribute' => ['parts_category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parts_category_id' => 'Parts Category ID',
            'parts_code' => 'Parts Code',
            'parts_name' => 'Name',
            'description' => 'Description',
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
    public function getPartsCategory()
    {
        return $this->hasOne(PartsCategory::className(), ['id' => 'parts_category_id']);
    }

    // Active Record joining relations
    public function getPartsById($id)
    {
        $rows = new Query();

        $result = $rows->select(['parts.*', 'parts_category.name'])
            ->from('parts')
            ->leftJoin('parts_category', 'parts.parts_category_id = parts_category.id')
            ->where(['parts.id' => $id])
            ->one();

        return $result;
    }

    // Active Record joining relations
    public function getPartsList()
    {
        $rows = new Query();

        $result = $rows->select(['parts.*', 'parts_category.name'])
            ->from('parts')
            ->leftJoin('parts_category', 'parts.parts_category_id = parts_category.id')
            ->all();

        return $result;
    }

}
