<?php

use yii\db\Migration;

/**
 * Handles the creation of table `purchase_order`.
 */
class m170502_061451_create_purchase_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('purchase_order', [
            'id' => $this->primaryKey(),
            'purchase_order_code' => $this->string(100),
            'user_id' => $this->integer(5),
            'supplier_id' => $this->integer(5),
            'date_issue' => $this->date(),
            'grand_total' => $this->double(10,2),
            'gst' => $this->double(10,2),
            'gst_value' => $this->double(10,2),
            'net' => $this->double(10,2),
            'remarks' => $this->text(),
            'payment_type_id' => $this->integer(5),
            'status' => $this->integer(5),
            'created_at' => $this->datetime(),
            'created_by' => $this->integer(5),
            'paid' => $this->integer(5),
            'deleted' => $this->integer(5),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('purchase_order');
    }
}
