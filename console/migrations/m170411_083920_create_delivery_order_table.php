<?php

use yii\db\Migration;

/**
 * Handles the creation of table `delivery_order`.
 */
class m170411_083920_create_delivery_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('delivery_order', [
            'id' => $this->primaryKey(),
            'delivery_order_code' => $this->string(100)->notNull(),
            'invoice_no' => $this->string(100)->notNull(),
            'user_id' => $this->integer(5)->notNull(),
            'customer_id' => $this->integer(5)->notNull(),
            'date_issue' => $this->date()->notNull(),
            'grand_total' => $this->double(10,2)->notNull(),
            'gst' => $this->double(10,2)->notNull(),
            'gst_value' => $this->double(10,2)->notNull(),
            'net' => $this->double(10,2)->notNull(),
            'remarks' => $this->text()->notNull(),
            'payment_type_id' => $this->integer(5)->notNull(),
            'discount_amount' => $this->double(10,2)->notNull(),
            'discount_remarks' => $this->text()->notNull(),
            'status' => $this->integer(5)->notNull(),
            'created_at' => $this->datetime()->notNull(),
            'created_by' => $this->integer(5)->notNull(),
            'updated_at' => $this->datetime()->notNull(),
            'updated_by' => $this->integer(5)->notNull(),
            'paid' => $this->integer(5)->notNull(),
            'deleted' => $this->integer(5)->notNull(),
            'condition' => $this->integer(5)->notNull(),
            'action_by' => $this->integer(5)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('delivery_order');
    }
}
