<?php

use yii\db\Migration;

class m170406_112228_create_payment_type_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-quotation-payment_type_id',
            'quotation',
            'payment_type_id',
            'payment_type',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk-invoice-payment_type_id',
            'invoice',
            'payment_type_id',
            'payment_type',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-quotation-payment_type_id', 'quotation');
        $this->dropForeignKey('fk-invoice-payment_type_id', 'invoice');
        // echo "m170406_112228_create_payment_type_foreignkey cannot be reverted.\n";

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
