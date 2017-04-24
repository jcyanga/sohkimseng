<?php

use yii\db\Migration;

class m170405_071119_add_columns_to_product_table extends Migration
{
    public function up()
    {
        $this->addColumn('product', 'supplier_id', $this->integer(5)->notNull());
        $this->addColumn('product', 'quantity', $this->integer(50)->notNull());
        $this->addColumn('product', 'cost_price', $this->double(10,2)->notNull());
        $this->addColumn('product', 'gst_price', $this->double(10,2)->notNull());
        $this->addColumn('product', 'selling_price', $this->double(10,2)->notNull());
        $this->addColumn('product', 'reorder_level', $this->integer(10)->notNull());
    }

    public function down()
    {
        $this->dropColumn('product', 'supplier_id');
        $this->dropColumn('product', 'quantity');
        $this->dropColumn('product', 'cost_price');
        $this->dropColumn('product', 'gst_price');
        $this->dropColumn('product', 'selling_price');
        $this->dropColumn('product', 'reorder_level');
        // echo "m170405_071119_add_columns_to_product_table cannot be reverted.\n";

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
