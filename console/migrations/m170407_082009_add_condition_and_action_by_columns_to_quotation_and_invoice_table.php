<?php

use yii\db\Migration;

/**
 * Handles adding condition_and_action_by to table `quotation_and_invoice`.
 */
class m170407_082009_add_condition_and_action_by_columns_to_quotation_and_invoice_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('quotation', 'condition', $this->integer(5)->notNull());
        $this->addColumn('quotation', 'action_by', $this->integer(5)->notNull());

        $this->addColumn('invoice', 'condition', $this->integer(5)->notNull());
        $this->addColumn('invoice', 'action_by', $this->integer(5)->notNull());
    }

    public function down()
    {
        $this->dropColumn('quotation', 'condition');
        $this->dropColumn('invoice', 'condition');

        $this->dropColumn('quotation', 'action_by');
        $this->dropColumn('invoice', 'action_by');
    }
}
