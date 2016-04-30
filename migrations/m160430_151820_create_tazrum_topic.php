<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tazrum.topic`.
 */
class m160430_151820_create_tazrum_topic extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{tazrum}}.{{%topic}}', [
            'id' => $this->primaryKey(),
            'subforum_id' => $this->integer()->comment('The subforum this topic is in, null is for private topics.'),
            'title' => $this->string(128)->notNull(),
            'user_id' => $this->integer()->notNull()->comment('The auth of the topic.'),
            'sticky' => $this->boolean()->notNull()->defaultValue(false)->comment('Whether the topic should stick to the top of the subforum listing.'),
            'locked' => $this->boolean()->notNull()->defaultValue(false)->comment('Whether people are barred from posting to this topic or not.'),
            'created_on' => $this->dateTime()->notNull(),
            'last_post_id' => $this->integer()->comment('That most recent post in this topic.'),
            'last_post_user_id' => $this->integer()->comment('The author of the most recent post in this topic.'),
            'last_post_on' => $this->dateTime()->comment('The datetime of the most recent post in this topic.'),
        ]);

        $this->createIndex('subforum_id', '{{tazrum}}.{{%topic}}', 'subforum_id');
        $this->createIndex('user_id', '{{tazrum}}.{{%topic}}', 'user_id');
        $this->createIndex('last_post_on', '{{tazrum}}.{{%topic}}', 'last_post_on');

        $this->addForeignKey('fk_subforum_topic', '{{tazrum}}.{{%topic}}', 'subforum_id', '{{tazrum}}.{{%subforum}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_user_topic', '{{tazrum}}.{{%topic}}', 'user_id', '{{tazrum}}.{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_last_post_user_topic', '{{tazrum}}.{{%topic}}', 'last_post_user_id', '{{tazrum}}.{{%user}}', 'id', 'RESTRICT', 'RESTRICT');

        $this->addForeignKey('fk_topic_subforum', '{{tazrum}}.{{%subforum}}', 'last_topic_id', '{{tazrum}}.{{%topic}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_topic_subforum', '{{tazrum}}.{{%subforum}}');

        $this->dropForeignKey('fk_last_post_user_topic', '{{tazrum}}.{{%topic}}');
        $this->dropForeignKey('fk_user_topic', '{{tazrum}}.{{%topic}}');
        $this->dropForeignKey('fk_subforum_topic', '{{tazrum}}.{{%topic}}');

        $this->dropIndex('last_post_on', '{{tazrum}}.{{%topic}}');
        $this->dropIndex('user_id', '{{tazrum}}.{{%topic}}');
        $this->dropIndex('subforum_id', '{{tazrum}}.{{%topic}}');

        $this->dropTable('{{tazrum}}.{{%topic}}');
    }
}
