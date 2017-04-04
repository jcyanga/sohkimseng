<?php

use yii\db\Migration;

class m170301_093809_create_invoice_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-invoice-user_id',
            'invoice',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk-invoice-customer_id',
            'invoice',
            'customer_id',
            'customer',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-invoice-user_id', 'invoice');
        $this->dropForeignKey('fk-invoice-customer_id', 'invoice');
        // echo "m170206_053020_create_quotation_customer_foreignkey cannot be reverted.\n";

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
