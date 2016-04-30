<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tazrum.post_read`.
 */
class m160430_155827_create_tazrum_post_read extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{tazrum}}.{{%post_read}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('User that has read the post.'),
            'topic_id' => $this->integer()->notNull()->comment('Topic the read post is in.'),
            'post_id' => $this->integer()->notNull()->comment('Post that has been read.'),
            'created_on' => $this->dateTime()->notNull()->comment('Moment user read post.'),
        ]);

        $this->createIndex('unique', '{{tazrum}}.{{%post_read}}', ['user_id', 'topic_id', 'post_id'], true);

        $this->addForeignKey('fk_post_post_read', '{{tazrum}}.{{%post_read}}', 'post_id', '{{%post}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_topic_post_read', '{{tazrum}}.{{%post_read}}', 'topic_id', '{{%topic}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_user_post_read', '{{tazrum}}.{{%post_read}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_user_post_read', '{{tazrum}}.{{%post_read}}');
        $this->dropForeignKey('fk_topic_post_read', '{{tazrum}}.{{%post_read}}');
        $this->dropForeignKey('fk_post_post_read', '{{tazrum}}.{{%post_read}}');

        $this->dropIndex('unique', '{{tazrum}}.{{%post_read}}');

        $this->dropTable('{{tazrum}}.{{%post_read}}');
    }
}
