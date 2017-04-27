<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parts_type`.
 */
class m170426_052009_create_parts_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('parts_type', [
            'id' => $this->primaryKey(),
            'parts_category_id' => $this->integer(5),
            'parts_id' => $this->integer(5),
            'status' => $this->integer(5),
            'created_at' => $this->datetime(),
            'created_by' => $this->integer(5),
            'updated_at' => $this->datetime(),
            'updated_by' => $this->integer(5),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('parts_type');
    }
}
