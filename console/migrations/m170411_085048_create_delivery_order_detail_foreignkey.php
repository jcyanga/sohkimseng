<?php

use yii\db\Migration;

class m170411_085048_create_delivery_order_detail_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-delivery_order_detail-delivery_order_id',
            'delivery_order_detail',
            'delivery_order_id',
            'delivery_order',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-delivery_order_detail-delivery_order_id', 'delivery_order_detail');
        // echo "m170411_085048_create_delivery_order_detail_foreignkey cannot be reverted.\n";

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
