<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_inventory`.
 */
class m170206_034043_create_product_inventory_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('product_inventory', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(5)->notNull(),
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
        $this->dropTable('product_inventory');
    }
}
