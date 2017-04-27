<?php

use yii\db\Migration;

class m170426_031827_add_columns_to_supplier_table extends Migration
{
    public function up()
    {
        $this->addColumn('supplier', 'remarks', $this->text());
        $this->addColumn('supplier', 'location', $this->string(100));
    }

    public function down()
    {
        $this->dropColumn('supplier', 'remarks');
        $this->dropColumn('supplier', 'location');
        // echo "m170426_031827_add_columns_to_supplier_table cannot be reverted.\n";

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
