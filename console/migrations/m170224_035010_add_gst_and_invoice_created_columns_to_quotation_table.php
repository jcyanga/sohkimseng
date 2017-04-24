<?php

use yii\db\Migration;

/**
 * Handles adding gst_and_invoice_created to table `quotation`.
 */
class m170224_035010_add_gst_and_invoice_created_columns_to_quotation_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quotation', 'gst', $this->double(10,2)->notNull());
        $this->addColumn('quotation', 'invoice_created', $this->integer(5)->notNull());
    }

    public function down()
    {
        $this->dropColumn('quotation', 'gst');
        $this->dropColumn('quotation', 'invoice_created');
    }
}
