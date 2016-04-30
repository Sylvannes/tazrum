<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tazrum.subforum`.
 */
class m160430_150124_create_tazrum_subforum extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{tazrum}}.{{%subforum}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
            'desc' => $this->text()->notNull(),
            'category_id' => $this->integer()->notNull()->comment('The category this subforum is in.'),
            'last_topic_id' => $this->integer()->comment('The topic inside this subforum that was most recently posted to.'),
        ]);

        $this->createIndex('category_id', '{{tazrum}}.{{%subforum}}', 'category_id');

        $this->addForeignKey('fk_category_subforum', '{{tazrum}}.{{%subforum}}', 'category_id', '{{tazrum}}.{{%category}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_category_subforum', '{{tazrum}}.{{%subforum}}');

        $this->dropIndex('category_id', '{{tazrum}}.{{%subforum}}');

        $this->dropTable('{{tazrum}}.{{%subforum}}');
    }
}
