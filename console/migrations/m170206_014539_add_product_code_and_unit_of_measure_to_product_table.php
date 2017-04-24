<?php

use yii\db\Migration;

class m170206_014539_add_product_code_and_unit_of_measure_to_product_table extends Migration
{
    public function up()
    {
        $this->addColumn('product', 'product_code', $this->string(100)->notNull());
        $this->addColumn('product', 'unit_of_measure', $this->string(100)->notNull());
    }

    public function down()
    {
        $this->dropColumn('product', 'product_code');
        $this->dropColumn('product', 'unit_of_measure');
        // echo "m170206_014539_add_product_code_and_unit_of_measure_to_product_table cannot be reverted.\n";

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
