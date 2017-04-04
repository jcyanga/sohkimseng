<?php

use yii\db\Migration;

/**
 * Handles the creation of table `gst`.
 */
class m170227_042157_create_gst_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('gst', [
            'id' => $this->primaryKey(),
            'branch_id' => $this->integer(10)->notNull()->unique(),
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
        $this->dropTable('branch');
    }
}
