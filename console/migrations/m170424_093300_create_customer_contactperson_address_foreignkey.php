<?php

use yii\db\Migration;

class m170424_093300_create_customer_contactperson_address_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-customer_contactperson_address-customer_id',
            'customer_contactperson_address',
            'customer_id',
            'customer',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-customer_contactperson_address-customer_id', 'customer_contactperson_address');
        // echo "m170424_093300_create_customer_contactperson_address_foreignkey cannot be reverted.\n";

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
