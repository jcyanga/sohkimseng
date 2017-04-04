<?php

use yii\db\Migration;

/**
 * Handles adding parts_code to table `parts`.
 */
class m170204_124417_add_parts_code_column_to_parts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('parts', 'parts_code', $this->string(100)->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('parts', 'parts_code');
    }
}
