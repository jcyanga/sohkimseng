<?php

use yii\db\Migration;

class m170405_071334_create_supplier_to_product_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-product-supplier_id',
            'product',
            'supplier_id',
            'supplier',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-product-supplier_id', 'parts');
        // echo "m170405_071334_create_supplier_to_product_foreignkey cannot be reverted.\n";

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
