<?php

use yii\db\Migration;

class m170404_080009_add_columns_to_customer_table extends Migration
{
    public function up()
    {
        $this->addColumn('customer', 'type', $this->integer(5)->notNull());
        $this->addColumn('customer', 'nric', $this->string(50)->notNull());
        $this->addColumn('customer', 'uen_no', $this->string(50)->notNull());
        $this->addColumn('customer', 'fax_number', $this->string(50)->notNull());
        $this->addColumn('customer', 'shipping_address', $this->text()->notNull());
    }

    public function down()
    {
        $this->dropColumn('customer', 'type');
        $this->dropColumn('customer', 'nric');
        $this->dropColumn('customer', 'uen_no');
        $this->dropColumn('customer', 'fax_number');
        $this->dropColumn('customer', 'shipping_address');
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
