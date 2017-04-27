<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parts_type".
 *
 * @property integer $id
 * @property integer $parts_category_id
 * @property integer $parts_id
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property PartsCategory $partsCategory
 * @property Parts $parts
 */
class PartsType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parts_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parts_category_id', 'parts_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['parts_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PartsCategory::className(), 'targetAttribute' => ['parts_category_id' => 'id']],
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
            'parts_category_id' => 'Parts Category ID',
            'parts_id' => 'Parts ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParts()
    {
        return $this->hasOne(Parts::className(), ['id' => 'parts_id']);
    }
}
