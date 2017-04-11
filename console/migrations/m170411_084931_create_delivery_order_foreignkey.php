<?php

use yii\db\Migration;

class m170411_084931_create_delivery_order_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-delivery_order-user_id',
            'delivery_order',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk-delivery_order-customer_id',
            'delivery_order',
            'customer_id',
            'customer',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-delivery_order-user_id', 'delivery_order');
        $this->dropForeignKey('fk-delivery_order-customer_id', 'delivery_order');
        // echo "m170411_084931_create_delivery_order_foreignkey cannot be reverted.\n";

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
