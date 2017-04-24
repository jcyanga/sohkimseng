<?php

use yii\db\Migration;

/**
 * Handles adding staff_group_id to table `staff`.
 */
class m170204_115659_add_staff_group_id_column_to_staff_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('staff', 'staff_group_id', $this->integer(5)->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('staff', 'staff_group_id');
    }
}
