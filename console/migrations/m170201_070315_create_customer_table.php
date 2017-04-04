<?php

use yii\db\Migration;

/**
 * Handles the creation of table `customer`.
 */
class m170201_070315_create_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('customer', [
            'id' => $this->primaryKey(),
            'fullname' => $this->string(100)->notNull()->unique(),
            'address' => $this->text()->notNull(),
            'race' => $this->string(50)->notNull(),
            'email' => $this->string(50)->notNull()->unique(),
            'phone_number' => $this->string(50)->notNull(),
            'mobile_number' => $this->string(50)->notNull(),
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
        $this->dropTable('customer');
    }
}
