<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_permission`.
 */
class m170130_041241_create_user_permission_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_permission', [
            'id' => $this->primaryKey(),
            'controller' => $this->string(50)->notNull(),
            'action' => $this->string(50)->notNull(),
            'role_id' => $this->integer(5)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_permission');
    }
}
