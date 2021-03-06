<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service_category`.
 */
class m170203_031024_create_service_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('service_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull()->unique(),
            'description' => $this->text()->notNull(),
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
        $this->dropTable('service_category');
    }
}
