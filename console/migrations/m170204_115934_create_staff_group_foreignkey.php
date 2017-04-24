<?php

use yii\db\Migration;

class m170204_115934_create_staff_group_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-staff-staff_group_id',
            'staff',
            'staff_group_id',
            'staff_group',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-staff-staff_group_id', 'staff');
        // echo "m170204_115934_create_staff_group_foreignkey cannot be reverted.\n";

        // return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
