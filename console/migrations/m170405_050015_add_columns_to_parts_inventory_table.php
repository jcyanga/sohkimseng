<?php

use yii\db\Migration;

class m170405_050015_add_columns_to_parts_inventory_table extends Migration
{
    public function up()
    {
        $this->addColumn('parts_inventory', 'old_quantity', $this->integer(25)->notNull());
        $this->addColumn('parts_inventory', 'new_quantity', $this->integer(25)->notNull());
        $this->addColumn('parts_inventory', 'qty_purchased', $this->integer(25)->notNull());
        $this->addColumn('parts_inventory', 'type', $this->integer(5)->notNull());
        $this->addColumn('parts_inventory', 'invoice_no', $this->string(50)->notNull());
        $this->addColumn('parts_inventory', 'datetime_imported', $this->datetime()->notNull());
        $this->addColumn('parts_inventory', 'datetime_purchased', $this->datetime()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('parts_inventory', 'old_quantity');
        $this->dropColumn('parts_inventory', 'new_quantity');
        $this->dropColumn('parts_inventory', 'qty_purchased');
        $this->dropColumn('parts_inventory', 'type');
        $this->dropColumn('parts_inventory', 'invoice_no');
        $this->dropColumn('parts_inventory', 'datetime_imported');
        $this->dropColumn('parts_inventory', 'datetime_purchased');
        // echo "m170405_050015_add_columns_to_parts_inventory_table cannot be reverted.\n";

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
