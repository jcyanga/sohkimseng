<?php

use yii\db\Migration;

/**
 * Handles the creation of table `storage_location`.
 */
class m170203_022141_create_storage_location_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('storage_location', [
            'id' => $this->primaryKey(),
            'rack' => $this->string(50)->notNull(),
            'bay' => $this->string(50)->notNull(),
            'level' => $this->string(50)->notNull(),
            'position' => $this->string(50)->notNull(),
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
        $this->dropTable('storage_location');
    }
}
