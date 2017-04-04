<?php

use yii\db\Migration;

class m170206_034256_create_product_inventory_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-product_inventory-product_id',
            'product_inventory',
            'product_id',
            'product',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk-product_inventory-supplier_id',
            'product_inventory',
            'supplier_id',
            'supplier',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-product_inventory-parts_id', 'product_inventory');
        $this->dropForeignKey('fk-product_inventory-supplier_id', 'product_inventory');
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
