<?php

use yii\db\Migration;

class m170405_030356_create_supplier_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-parts-supplier_id',
            'parts',
            'supplier_id',
            'supplier',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-parts-supplier_id', 'parts');
        // echo "m170405_030356_create_supplier_foreignkey cannot be reverted.\n";

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
