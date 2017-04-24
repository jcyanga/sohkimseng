<?php

use yii\db\Migration;

/**
 * Handles adding storage_location_id to table `parts`.
 */
class m170406_052219_add_storage_location_id_column_to_parts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('parts', 'storage_location_id', $this->integer(5)->notNull());
    }

    public function down()
    {
        $this->dropColumn('parts', 'storage_location_id');
    }
}
