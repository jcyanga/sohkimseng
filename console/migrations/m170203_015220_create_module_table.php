<?php

use yii\db\Migration;

/**
 * Handles the creation of table `module`.
 */
class m170203_015220_create_module_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('module', [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull()->unique(),
            'status' => $this->integer(5)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'updated_at' => $this->datetime()->notNull(),
            'updated_by' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('module');
    }
}
