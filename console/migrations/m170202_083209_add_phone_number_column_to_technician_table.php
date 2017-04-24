<?php

use yii\db\Migration;

/**
 * Handles adding phone_number to table `technician`.
 */
class m170202_083209_add_phone_number_column_to_technician_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('technician', 'phone_number', $this->string(50)->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('technician', 'phone_number');
    }
}
