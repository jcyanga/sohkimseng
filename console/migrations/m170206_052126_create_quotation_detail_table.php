<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quotation_detail`.
 */
class m170206_052126_create_quotation_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('quotation_detail', [
            'id' => $this->primaryKey(),
            'quotation_id' => $this->integer(5)->notNull(),
            'description' => $this->integer(5)->notNull(),
            'quantity' => $this->integer(5)->notNull(),
            'unit_price' => $this->double(10,2)->notNull(),
            'sub_total' => $this->double(10,2)->notNull(),
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
        $this->dropTable('quotation_detail');
    }
}
