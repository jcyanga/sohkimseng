<?php

use yii\db\Migration;

/**
 * Handles the creation of table `purchase_order_detail`.
 */
class m170502_061501_create_purchase_order_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('purchase_order_detail', [
            'id' => $this->primaryKey(),
            'purchase_order_id' => $this->integer(5),
            'parts_products' => $this->integer(5)->notNull(),
            'quantity' => $this->integer(5)->notNull(),
            'unit_price' => $this->double(10,2)->notNull(),
            'sub_total' => $this->double(10,2)->notNull(),
            'type' => $this->integer(5)->notNull(),
            'status' => $this->integer(5)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'deleted' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('purchase_order_detail');
    }
}
