<?php

use yii\db\Migration;

/**
 * Handles the creation of table `quotation`.
 */
class m170206_043840_create_quotation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('quotation', [
            'id' => $this->primaryKey(),
            'quotation_code' => $this->string(100)->notNull(),
            'user_id' => $this->integer(5)->notNull(),
            'customer_id' => $this->integer(5)->notNull(),
            'date_issue' => $this->date()->notNull(),
            'grand_total' => $this->double(10,2)->notNull(),
            'net' => $this->double(10,2)->notNull(),
            'remarks' => $this->text()->notNull(),
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
        $this->dropTable('quotation');
    }
}
