<?php

use yii\db\Migration;

class m170301_093951_create_invoice_detail_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-invoice_detail-invoice_id',
            'invoice_detail',
            'invoice_id',
            'invoice',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-invoice_detail-invoice_id', 'invoice_detail');
        // echo "m170206_053250_create_quotation_detail_foreignkey cannot be reverted.\n";

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
