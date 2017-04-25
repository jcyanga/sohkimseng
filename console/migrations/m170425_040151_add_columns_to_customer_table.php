<?php

use yii\db\Migration;

class m170425_040151_add_columns_to_customer_table extends Migration
{
    public function up()
    {
        $this->addColumn('customer', 'customer_code', $this->string(150));
        $this->addColumn('customer', 'remarks', $this->text());
        $this->addColumn('customer', 'location', $this->string(100));
    }

    public function down()
    {
        $this->dropColumn('customer', 'customer_code');
        $this->dropColumn('customer', 'remarks');
        $this->dropColumn('customer', 'location');
        // echo "m170425_040151_add_columns_to_customer_table cannot be reverted.\n";

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
