<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tazrum.post`.
 */
class m160430_153016_create_tazrum_post extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{tazrum}}.{{%post}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Author of the post.'),
            'topic_id' => $this->integer()->notNull()->comment('Topic the post is in.'),
            'text' => $this->text()->notNull(),
            'created_on' => $this->dateTime()->notNull(),
            'edits' => $this->integer()->notNull()->defaultValue(0),
            'last_edited_by_user_id' => $this->integer(),
            'last_edited_on' => $this->dateTime(),
            'fluttered' => $this->boolean()->defaultValue(false)->comment('Whether the post has been submitted to Flutterby.')
        ]);

        $this->createIndex('user_id', '{{tazrum}}.{{%post}}', 'user_id');
        $this->createIndex('topic_id', '{{tazrum}}.{{%post}}', 'topic_id');
        $this->createIndex('created_on', '{{tazrum}}.{{%post}}', 'created_on');
        // Yii Migrations does not support creating FULLTEXT indices, need to use a raw query.
        $this->execute('CREATE FULLTEXT INDEX `text` ON `tazrum`.`post` (`text`)');

        $this->addForeignKey('fk_topic_post', '{{tazrum}}.{{%post}}', 'topic_id', '{{tazrum}}.{{%topic}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_user_post', '{{tazrum}}.{{%post}}', 'user_id', '{{tazrum}}.{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_last_edited_user_post', '{{tazrum}}.{{%post}}', 'last_edited_by_user_id', '{{tazrum}}.{{%user}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->addForeignKey('fk_post_topic', '{{tazrum}}.{{%topic}}', 'last_post_id', '{{tazrum}}.{{%post}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_post_topic', '{{tazrum}}.{{%topic}}');

        $this->dropForeignKey('fk_last_edited_user_post', '{{tazrum}}.{{%post}}');
        $this->dropForeignKey('fk_user_post', '{{tazrum}}.{{%post}}');
        $this->dropForeignKey('fk_topic_post', '{{tazrum}}.{{%post}}');

        $this->dropIndex('text', '{{tazrum}}.{{%post}}');
        $this->dropIndex('created_on', '{{tazrum}}.{{%post}}');
        $this->dropIndex('topic_id', '{{tazrum}}.{{%post}}');
        $this->dropIndex('user_id', '{{tazrum}}.{{%post}}');

        $this->dropTable('{{tazrum}}.{{%post}}');
    }
}
