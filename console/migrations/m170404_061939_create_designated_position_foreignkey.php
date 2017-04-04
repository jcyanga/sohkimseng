<?php

use yii\db\Migration;

class m170404_061939_create_designated_position_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-staff-designated_position_id',
            'staff',
            'designated_position_id',
            'designated_position',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-staff-designated_position_id', 'staff');
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
