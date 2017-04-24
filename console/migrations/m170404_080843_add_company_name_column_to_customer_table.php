<?php

use yii\db\Migration;

/**
 * Handles adding company_name to table `customer`.
 */
class m170404_080843_add_company_name_column_to_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('customer', 'company_name', $this->string(100)->notNull()->unique());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('customer', 'company_name');
    }
}
