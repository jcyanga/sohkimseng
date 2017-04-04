<?php

use yii\db\Migration;

class m170404_061727_add_designated_position_id_to_staff_table extends Migration
{
    public function up()
    {
        $this->addColumn('staff', 'designated_position_id', $this->integer(5)->notNull());
    }

    public function down()
    {
        $this->dropColumn('staff', 'designated_position_id');
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
