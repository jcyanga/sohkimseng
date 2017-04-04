<?php

use yii\db\Migration;

class m170206_053020_create_quotation_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-quotation-user_id',
            'quotation',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk-quotation-customer_id',
            'quotation',
            'customer_id',
            'customer',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-quotation-user_id', 'quotation');
        $this->dropForeignKey('fk-quotation-customer_id', 'quotation');
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
