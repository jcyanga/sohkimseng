<?php

use yii\db\Migration;

class m170204_090644_create_product_category_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-product-product_category_id',
            'product',
            'product_category_id',
            'product_category',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-product-product_category_id', 'product');
        // echo "m170204_090644_create_product_category_foreignkey cannot be reverted.\n";

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
