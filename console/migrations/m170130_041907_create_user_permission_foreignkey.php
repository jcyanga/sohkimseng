<?php

use yii\db\Migration;

class m170130_041907_create_user_permission_foreignkey extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-user_permission-role_id',
            'user_permission',
            'role_id',
            'role',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    public function down()
    {
        $this->dropForeignKey('fk-user_permission-role_id', 'user_permission');
        // echo "m170130_041907_create_user_permission_foreignkey cannot be reverted.\n";

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
