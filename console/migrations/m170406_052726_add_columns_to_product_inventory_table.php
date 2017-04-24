<?php

use yii\db\Migration;

class m170406_052726_add_columns_to_product_inventory_table extends Migration
{
    public function up()
    {
        $this->addColumn('product_inventory', 'old_quantity', $this->integer(25)->notNull());
        $this->addColumn('product_inventory', 'new_quantity', $this->integer(25)->notNull());
        $this->addColumn('product_inventory', 'qty_purchased', $this->integer(25)->notNull());
        $this->addColumn('product_inventory', 'type', $this->integer(5)->notNull());
        $this->addColumn('product_inventory', 'invoice_no', $this->string(50)->notNull());
        $this->addColumn('product_inventory', 'datetime_imported', $this->datetime()->notNull());
        $this->addColumn('product_inventory', 'datetime_purchased', $this->datetime()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('product_inventory', 'old_quantity');
        $this->dropColumn('product_inventory', 'new_quantity');
        $this->dropColumn('product_inventory', 'qty_purchased');
        $this->dropColumn('product_inventory', 'type');
        $this->dropColumn('product_inventory', 'invoice_no');
        $this->dropColumn('product_inventory', 'datetime_imported');
        $this->dropColumn('product_inventory', 'datetime_purchased');
        // echo "m170406_052726_add_columns_to_product_inventory_table cannot be reverted.\n";

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
