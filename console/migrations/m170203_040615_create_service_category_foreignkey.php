<?php

use yii\db\Migration;

class m170203_040615_create_service_category_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-service-service_category_id',
            'service',
            'service_category_id',
            'service_category',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-service-service_category_id', 'service');
        // echo "m170203_040615_create_service_category_foreignkey cannot be reverted.\n";

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
