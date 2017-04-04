<?php

use yii\db\Migration;

/**
 * Handles the creation of table `staff`.
 */
class m170202_064144_create_staff_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('staff', [
            'id' => $this->primaryKey(),
            'fullname' => $this->string(100)->notNull()->unique(),
            'address' => $this->text()->notNull(),
            'race' => $this->string(50)->notNull(),
            'email' => $this->string(50)->notNull()->unique(),
            'mobile_number' => $this->string(50)->notNull(),
            'status' => $this->integer(5)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'updated_at' => $this->datetime()->notNull(),
            'updated_by' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('staff');
    }
}
