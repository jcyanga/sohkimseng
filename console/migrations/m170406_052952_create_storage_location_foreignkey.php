<?php

use yii\db\Migration;

class m170406_052952_create_storage_location_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-parts-storage_location_id',
            'parts',
            'storage_location_id',
            'storage_location',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk-product-storage_location_id',
            'product',
            'storage_location_id',
            'storage_location',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-parts-storage_location_id', 'parts');
        $this->dropForeignKey('fk-product-storage_location_id', 'product');
        // echo "m170406_052952_create_storage_location_foreignkey cannot be reverted.\n";

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
