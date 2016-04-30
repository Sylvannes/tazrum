<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tazrum.user_salt`.
 */
class m160430_172108_create_tazrum_user_salt extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{tazrum}}.{{%user_salt}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('The user this salt belongs to.'),
            'salt' => $this->string(40)->notNull()->comment('Randomly generated salt used for generating hashes for this user specifically.'),
        ]);

        $this->createIndex('unique', '{{tazrum}}.{{%user_salt}}', 'user_id', true);

        $this->addForeignKey('fk_user_user_salt', '{{tazrum}}.{{%user_salt}}', 'user_id', '{{tazrum}}.{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_user_user_salt', '{{tazrum}}.{{%user_salt}}');

        $this->dropIndex('unique', '{{tazrum}}.{{%user_salt}}');

        $this->dropTable('{{tazrum}}.{{%user_salt}}');
    }
}
