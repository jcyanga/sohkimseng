<?php

use yii\db\Migration;

class m170406_111715_add_columns_to_quotation_and_invoice_table extends Migration
{
    public function up()
    {
        $this->addColumn('quotation', 'payment_type_id', $this->integer(5)->notNull());
        $this->addColumn('quotation', 'discount_amount', $this->double(10,2)->notNull());
        $this->addColumn('quotation', 'discount_remarks', $this->text()->notNull());

        $this->addColumn('invoice', 'payment_type_id', $this->integer(5)->notNull());
        $this->addColumn('invoice', 'discount_amount', $this->double(10,2)->notNull());
        $this->addColumn('invoice', 'discount_remarks', $this->text()->notNull());
    }

    public function down()
    {
        $this->dropColumn('quotation', 'payment_type_id');
        $this->dropColumn('quotation', 'discount_amount');
        $this->dropColumn('quotation', 'discount_remarks');

        $this->dropColumn('invoice', 'payment_type_id');
        $this->dropColumn('invoice', 'discount_amount');
        $this->dropColumn('invoice', 'discount_remarks');

        // echo "m170406_111715_add_columns_to_quotation_and_invoice_table cannot be reverted.\n";

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
