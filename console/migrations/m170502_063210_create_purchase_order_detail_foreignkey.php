<?php

use yii\db\Migration;

class m170502_063210_create_purchase_order_detail_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-purchase_order_detail-purchase_order_id',
            'purchase_order_detail',
            'purchase_order_id',
            'purchase_order',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-purchase_order_detail-purchase_order_id', 'purchase_order_detail');
        // echo "m170502_063210_create_purchase_order_detail_foreignkey cannot be reverted.\n";

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
