<?php

use yii\db\Migration;

class m170204_063740_create_parts_category_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-parts-parts_category_id',
            'parts',
            'parts_category_id',
            'parts_category',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-parts-parts_category_id', 'parts');
        // echo "m170204_063740_create_parts_category_foreignkey cannot be reverted.\n";

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
