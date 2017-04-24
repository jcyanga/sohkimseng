<?php

use yii\db\Migration;

/**
 * Handles adding remarks to table `parts`.
 */
class m170417_071216_add_remarks_column_to_parts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('parts', 'remarks', $this->text()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('parts', 'remarks');
    }
}
