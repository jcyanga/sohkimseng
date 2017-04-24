<?php

use yii\db\Migration;

/**
 * Handles the creation of table `supplier`.
 */
class m170202_094525_create_supplier_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('supplier', [
            'id' => $this->primaryKey(),
            'supplier_code' => $this->string(150)->notNull()->unique(),
            'name' => $this->string(100)->notNull()->unique(),
            'address' => $this->text()->notNull(),
            'contact_number' => $this->string(50)->notNull(),
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
        $this->dropTable('supplier');
    }
}
