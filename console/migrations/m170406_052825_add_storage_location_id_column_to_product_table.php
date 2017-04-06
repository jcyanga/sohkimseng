<?php

use yii\db\Migration;

/**
 * Handles adding storage_location_id to table `product`.
 */
class m170406_052825_add_storage_location_id_column_to_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('product', 'storage_location_id', $this->integer(5)->notNull());
    }

    public function down()
    {
        $this->dropColumn('product', 'storage_location_id');
    }
}
