<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service`.
 */
class m170203_040219_create_service_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('service', [
            'id' => $this->primaryKey(),
            'service_category_id' => $this->integer(5)->notNull(),
            'service_name' => $this->string(150)->notNull()->unique(),
            'description' => $this->text()->notNull(),
            'price' => $this->double(10,2)->notNull(),
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
        $this->dropTable('service');
    }
}
