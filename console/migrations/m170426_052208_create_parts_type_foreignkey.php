<?php

use yii\db\Migration;

class m170426_052208_create_parts_type_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-parts_type-parts_category_id',
            'parts_type',
            'parts_category_id',
            'parts_category',
            'id',
            'CASCADE',
            'CASCADE'
            );

        $this->addForeignKey(
            'fk-parts_type-parts_id',
            'parts_type',
            'parts_id',
            'parts',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-parts_type-parts_category_id', 'parts_type');
        $this->dropForeignKey('fk-parts_type-parts_id', 'parts_type');
        // echo "m170426_052208_create_parts_type_foreignkey cannot be reverted.\n";

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
