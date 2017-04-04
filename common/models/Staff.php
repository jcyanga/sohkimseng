<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "staff".
 *
 * @property integer $id
 * @property integer $staff_group_id
 * @property integer $desigated_position_id
 * @property string $fullname
 * @property string $address
 * @property string $race_id
 * @property string $email
 * @property string $mobile_number
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property StaffGroup $staffGroup
 * @property DesignatedPosition $designatedPosition
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_group_id', 'designated_position_id', 'fullname', 'address', 'race_id', 'email', 'mobile_number', 'status'], 'required', 'message' => 'Fill up all the required fields.'],
            [['address'], 'string'],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['fullname'], 'string', 'max' => 100],
            [['race_id', 'email', 'mobile_number'], 'string', 'max' => 50],
            [['fullname'], 'unique', 'message' => 'Fullname already exist.'],
            [['email'], 'unique', 'message' => 'Email already exist.'],
            [['staff_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffGroup::className(), 'targetAttribute' => ['staff_group_id' => 'id']],
            [['designated_position_id'], 'exist', 'skipOnError' => true, 'targetClass' => DesignatedPosition::className(), 'targetAttribute' => ['designated_position_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'address' => 'Address',
            'race_id' => 'Race',
            'email' => 'Email',
            'mobile_number' => 'Mobile Number',
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
    public function getStaffGroup()
    {
        return $this->hasOne(StaffGroup::className(), ['id' => 'staff_group_id']);
    }

    public function getDesignatedPosition()
    {
        return $this->hasOne(DesignatedPosition::className(), ['id' => 'designated_position_id']);
    }

    // Active Record joining relations
    public function getStaffById($id)
    {
        $rows = new Query();

        $result = $rows->select(['staff.*', 'staff_group.name', 'race.name as raceName', 'designated_position.name as positionName'])
            ->from('staff')
            ->leftJoin('staff_group', 'staff.staff_group_id = staff_group.id')
            ->leftJoin('designated_position', 'staff.designated_position_id = designated_position.id')
            ->leftJoin('race', 'staff.race_id = race.id')
            ->where(['staff.id' => $id])
            ->andWhere(['staff.status' => 1])
            ->one();

        return $result;
    }

    // Active Record joining relations
    public function getStaffList()
    {
        $rows = new Query();

        $result = $rows->select(['staff.*', 'staff_group.name', 'race.name as raceName', 'designated_position.name as positionName'])
            ->from('staff')
            ->leftJoin('staff_group', 'staff.staff_group_id = staff_group.id')
            ->leftJoin('designated_position', 'staff.designated_position_id = designated_position.id')
            ->leftJoin('race', 'staff.race_id = race.id')
            ->where(['staff.status' => 1])
            ->all();

        return $result;
    }

    // get staff with race info by id
    public function getStaffs($id)
    {
        $query = new Query();

        $result = $query->select(['staff.*', 'race.name'])
                            ->from('staff')
                            ->leftJoin('race', 'staff.race_id = race.id')
                            ->where(['staff.id' => $id])
                            ->andWhere(['staff.status' => 1])
                            ->one();

        return $result;
        
    }

}
