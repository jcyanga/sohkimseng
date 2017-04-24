<?php

use yii\db\Migration;

class m170405_025933_add_columns_to_parts_table extends Migration
{
    public function up()
    {
        $this->addColumn('parts', 'supplier_id', $this->integer(5)->notNull());
        $this->addColumn('parts', 'quantity', $this->integer(50)->notNull());
        $this->addColumn('parts', 'cost_price', $this->double(10,2)->notNull());
        $this->addColumn('parts', 'gst_price', $this->double(10,2)->notNull());
        $this->addColumn('parts', 'selling_price', $this->double(10,2)->notNull());
        $this->addColumn('parts', 'reorder_level', $this->integer(10)->notNull());
    }

    public function down()
    {
        $this->dropColumn('parts', 'supplier_id');
        $this->dropColumn('parts', 'quantity');
        $this->dropColumn('parts', 'cost_price');
        $this->dropColumn('parts', 'gst_price');
        $this->dropColumn('parts', 'selling_price');
        $this->dropColumn('parts', 'reorder_level');
        // echo "m170405_025933_add_columns_to_parts_table cannot be reverted.\n";

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
