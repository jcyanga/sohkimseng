<?php

use yii\db\Migration;

/**
 * Handles adding gst_value to table `quotation_and_invoice`.
 */
class m170410_050145_add_gst_value_column_to_quotation_and_invoice_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quotation', 'gst_value', $this->double(10,2)->notNull());
        $this->addColumn('invoice', 'gst_value', $this->double(10,2)->notNull());
    }

    public function down()
    {
        $this->dropColumn('quotation', 'gst_value');
        $this->dropColumn('invoice', 'gst_value');
    }
}
