<?php

use yii\db\Migration;

/**
 * Handles adding unit_of_measure to table `parts`.
 */
class m170204_124807_add_unit_of_measure_column_to_parts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('parts', 'unit_of_measure', $this->string(100)->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('parts', 'unit_of_measure');
    }
}
