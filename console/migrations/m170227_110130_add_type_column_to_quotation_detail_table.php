<?php

use yii\db\Migration;

/**
 * Handles adding type to table `quotation_detail`.
 */
class m170227_110130_add_type_column_to_quotation_detail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quotation_detail', 'type', $this->integer(5)->notNull());
    }

    public function down()
    {
        $this->dropColumn('quotation_detail', 'type');
    }
}
