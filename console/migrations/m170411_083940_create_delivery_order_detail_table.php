<?php

use yii\db\Migration;

class m170411_083940_create_delivery_order_detail_table extends Migration
{
    public function up()
    {
        $this->createTable('delivery_order_detail', [
            'id' => $this->primaryKey(),
            'delivery_order_id' => $this->integer(5)->notNull(),
            'description' => $this->integer(5)->notNull(),
            'quantity' => $this->integer(5)->notNull(),
            'unit_price' => $this->double(10,2)->notNull(),
            'sub_total' => $this->double(10,2)->notNull(),
            'type' => $this->integer(5)->notNull(),
            'status' => $this->integer(5)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'updated_at' => $this->datetime()->notNull(),
            'updated_by' => $this->integer(5)->notNull(),
            'deleted' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('delivery_order_detail');
    }
}
