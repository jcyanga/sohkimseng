<?php

use yii\db\Migration;

class m170204_142853_create_parts_inventory_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-parts_inventory-parts_id',
            'parts_inventory',
            'parts_id',
            'parts',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk-parts_inventory-supplier_id',
            'parts_inventory',
            'supplier_id',
            'supplier',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-parts_inventory-parts_id', 'parts_inventory');
        $this->dropForeignKey('fk-parts_inventory-supplier_id', 'parts_inventory');
        // echo "m170204_142853_create_parts_inventory_foreignkey cannot be reverted.\n";

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
