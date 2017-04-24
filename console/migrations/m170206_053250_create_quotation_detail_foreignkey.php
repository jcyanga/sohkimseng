<?php

use yii\db\Migration;

class m170206_053250_create_quotation_detail_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-quotation_detail-quotation_id',
            'quotation_detail',
            'quotation_id',
            'quotation',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-quotation_detail-quotation_id', 'quotation_detail');
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
