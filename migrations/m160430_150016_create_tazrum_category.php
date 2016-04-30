<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tazrum.category`.
 */
class m160430_150016_create_tazrum_category extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{tazrum}}.{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
            'order' => $this->smallInteger()->comment('Order in which the categories appear on the index.'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{tazrum}}.{{%category}}');
    }
}
