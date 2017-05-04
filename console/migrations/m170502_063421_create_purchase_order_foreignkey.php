<?php

use yii\db\Migration;

class m170502_063421_create_purchase_order_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-purchase_order-user_id',
            'purchase_order',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk-purchase_order-supplier_id',
            'purchase_order',
            'supplier_id',
            'supplier',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-purchase_order-user_id', 'purchase_order');
        $this->dropForeignKey('fk-purchase_order-supplier_id', 'purchase_order');
        // echo "m170502_063421_create_purchase_order_foreignkey cannot be reverted.\n";

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
