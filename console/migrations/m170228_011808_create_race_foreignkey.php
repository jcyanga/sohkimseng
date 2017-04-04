<?php

use yii\db\Migration;

class m170228_011808_create_race_foreignkey extends Migration
{
    public function up()
    {
         $this->addForeignKey(
            'fk-customer-race_id',
            'customer',
            'race_id',
            'race',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk-staff-race_id',
            'staff',
            'race_id',
            'race',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-customer-race_id', 'customer');
        $this->dropForeignKey('fk-staff-race_id', 'staff');
        // echo "m170206_034256_create_product_inventory_foreignkey cannot be reverted.\n";

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
