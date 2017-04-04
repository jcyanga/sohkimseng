<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "storage_location".
 *
 * @property integer $id
 * @property string $rack
 * @property string $bay
 * @property string $level
 * @property string $position
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class StorageLocations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'storage_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rack', 'bay', 'level', 'position', 'status'], 'required', 'message' => 'Fill up all the required fields.'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['rack', 'bay', 'level', 'position'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rack' => 'Rack',
            'bay' => 'Bay',
            'level' => 'Level',
            'position' => 'Position',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
