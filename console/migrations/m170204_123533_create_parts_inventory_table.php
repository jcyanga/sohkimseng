<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parts_inventory`.
 */
class m170204_123533_create_parts_inventory_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('parts_inventory', [
            'id' => $this->primaryKey(),
            'parts_id' => $this->integer(5)->notNull(),
            'supplier_id' => $this->integer(5)->notNull(),
            'quantity' => $this->integer(10)->notNull(),
            'price' => $this->double(10,2)->notNull(),
            'status' => $this->integer(5)->notNull(),
            'date_imported' => $this->date()->notNull(), 
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
        $this->dropTable('parts_inventory');
    }
}
