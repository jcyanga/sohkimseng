<?php

use yii\db\Migration;

/**
 * Handles the creation of table `role`.
 */
class m170130_040250_create_role_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('role', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()->unique(),
            'status' => $this->integer(5)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'updated_at' => $this->datetime()->notNull(),
            'updated_by' => $this->integer(5)->notNull(),
        ]);

        $this->addForeignKey(
            'fk-user-role_id',
            'user',
            'role_id',
            'role',
            'id',
            'CASCADE',
            'CASCADE'
            );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('role');

        $this->dropForeignKey('fk-user-role_id', 'user');
    }
}
