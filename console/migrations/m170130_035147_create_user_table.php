<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170130_035147_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer(10)->notNull(),
            'role' => $this->integer(5)->notNull(),
            'fullname' => $this->string(50)->notNull(),
            'email' => $this->string(50)->notNull()->unique(),    
            'username' => $this->string(50)->notNull()->unique(),
            'password' => $this->string(50)->notNull(),
            'password_hash' => $this->string(100)->notNull(),
            'password_reset_token' => $this->string(100)->notNull(),
            'auth_key' => $this->string(50)->notNull(),
            'image' => $this->string(50)->notNull(),
            'status' => $this->integer(5)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'updated_at' => $this->datetime()->notNull(),
            'updated_by' => $this->integer(5)->notNull(),
            'deleted' => $this->integer(5)->notNull(),
        ]);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
        
    }
}
