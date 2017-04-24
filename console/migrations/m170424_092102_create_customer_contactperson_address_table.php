<?php

use yii\db\Migration;

/**
 * Handles the creation of table `create_customer_contactperson_address`.
 */
class m170424_092102_create_customer_contactperson_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('customer_contactperson_address', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(5)->notNull(),
            'address' => $this->text()->notNull(),
            'contact_person' => $this->string(50)->notNull(),
            'status' => $this->integer(5)->notNull(),
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
        $this->dropTable('customer_contactperson_address');
    }
}
