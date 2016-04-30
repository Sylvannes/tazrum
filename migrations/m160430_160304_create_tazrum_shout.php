<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tazrum.shout`.
 */
class m160430_160304_create_tazrum_shout extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{tazrum}}.{{%shout}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('The author of the shout.'),
            'to_user_id' => $this->integer()->comment('In case of whispers, the person being whispered to.'),
            'text' => $this->text()->notNull(),
            'created_on' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex('user_id', '{{tazrum}}.{{%shout}}', 'user_id');
        $this->createIndex('to_user_id', '{{tazrum}}.{{%shout}}', 'to_user_id');
        $this->createIndex('created_on', '{{tazrum}}.{{%shout}}', 'created_on');

        $this->addForeignKey('fk_user_shout', '{{tazrum}}.{{%shout}}', 'user_id', '{{tazrum}}.{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_to_user_shout', '{{tazrum}}.{{%shout}}', 'to_user_id', '{{tazrum}}.{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_to_user_shout', '{{tazrum}}.{{%shout}}');
        $this->dropForeignKey('fk_user_shout', '{{tazrum}}.{{%shout}}');

        $this->dropIndex('created_on', '{{tazrum}}.{{%shout}}');
        $this->dropIndex('to_user_id', '{{tazrum}}.{{%shout}}');
        $this->dropIndex('user_id', '{{tazrum}}.{{%shout}}');

        $this->dropTable('{{tazrum}}.{{%shout}}');
    }
}
