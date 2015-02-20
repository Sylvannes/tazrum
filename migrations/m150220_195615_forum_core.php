<?php

use yii\db\Schema;
use yii\db\Migration;

class m150220_195615_forum_core extends Migration
{
    public function up()
    {

        $tableOptions = "";
        /* MYSQL */
        $this->createTable('{{%category}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'name' => 'VARCHAR(32) NOT NULL',
            'order' => 'INT(11) NOT NULL',
        ], $tableOptions);

        $tableOptions = "";
        /* MYSQL */
        $this->createTable('{{%post}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'user_id' => 'INT(11) NOT NULL',
            'topic_id' => 'INT(11) NOT NULL',
            'text' => 'TEXT NOT NULL',
            'created_on' => 'DATETIME NOT NULL',
            'edits' => 'INT(11) NOT NULL',
            'last_edited_by_user_id' => 'INT(11) NULL',
            'last_edited_on' => 'DATETIME NULL',
            'fluttered' => 'TINYINT(4) NOT NULL',
        ], $tableOptions);

        $tableOptions = "";
        /* MYSQL */
        $this->createTable('{{%post_read}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'user_id' => 'INT(11) NOT NULL',
            'topic_id' => 'INT(11) NOT NULL',
            'post_id' => 'INT(11) NOT NULL',
            'created_on' => 'DATETIME NOT NULL',
        ], $tableOptions);

        $tableOptions = "";
        /* MYSQL */
        $this->createTable('{{%shout}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'user_id' => 'INT(11) NOT NULL',
            'to_user_id' => 'INT(11) NULL',
            'text' => 'TEXT NOT NULL',
            'created_on' => 'DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\'',
        ], $tableOptions);

        $tableOptions = "";
        /* MYSQL */
        $this->createTable('{{%subforum}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'name' => 'VARCHAR(32) NOT NULL',
            'desc' => 'TEXT NOT NULL',
            'category_id' => 'INT(11) NOT NULL',
            'last_topic_id' => 'INT(11) NULL',
        ], $tableOptions);

        $tableOptions = "";
        /* MYSQL */
        $this->createTable('{{%topic}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'subforum_id' => 'INT(11) NULL',
            'title' => 'VARCHAR(128) NOT NULL',
            'user_id' => 'INT(11) NOT NULL',
            'sticky' => 'INT(1) NOT NULL',
            'locked' => 'INT(1) NOT NULL',
            'private' => 'INT(1) NOT NULL',
            'created_on' => 'DATETIME NOT NULL',
            'last_post_id' => 'INT(11) NULL',
            'last_post_user_id' => 'INT(11) NULL',
            'last_post_on' => 'DATETIME NULL',
        ], $tableOptions);

        $tableOptions = "";
        /* MYSQL */
        $this->createTable('{{%user}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'name' => 'VARCHAR(20) NOT NULL',
            'password' => 'VARCHAR(32) NOT NULL',
            'auth_key' => 'VARCHAR(32) NOT NULL',
            'email' => 'VARCHAR(150) NOT NULL',
            'rank' => 'INT(1) NOT NULL DEFAULT \'2\'',
            'location' => 'VARCHAR(128) NULL',
            'posts' => 'INT(11) NOT NULL',
            'shouts' => 'INT(11) NOT NULL',
            'topics' => 'INT(11) NOT NULL',
            'polls' => 'INT(11) NOT NULL',
            'articles' => 'INT(11) NOT NULL',
            'shoutrpg_wins' => 'INT(11) NOT NULL',
            'shoutrpg_losses' => 'INT(11) NOT NULL',
            'hide_email' => 'TINYINT(4) NOT NULL',
            'birth_date' => 'DATE NULL',
            'last_login' => 'DATETIME NULL',
            'last_ip' => 'VARCHAR(16) NOT NULL',
            'registered_on' => 'DATETIME NOT NULL',
            'banned_on' => 'DATETIME NULL',
            'deleted_on' => 'DATETIME NULL',
            'banned_by_user_id' => 'INT(11) NULL',
            'deleted_by_user_id' => 'INT(11) NULL',
            'status' => 'ENUM(\'inactive\',\'active\',\'banned\',\'deleted\') NOT NULL DEFAULT \'inactive\'',
            'activation_code' => 'VARCHAR(32) NOT NULL',
            'modules' => 'VARCHAR(128) NOT NULL DEFAULT \'1,8,3,7,5,2,9,6,4\'',
            'achievement_points' => 'INT(11) NOT NULL',
            'avatar' => 'VARCHAR(128) NULL',
            'signature' => 'TEXT NULL',
            'profile_text' => 'TEXT NULL',
            'forum_location' => 'TEXT NOT NULL',
            'real_name' => 'VARCHAR(128) NULL',
            'gender' => 'ENUM(\'Man\',\'Vrouw\') NULL',
            'private_messages' => 'INT(11) NOT NULL',
            'custom_status' => 'VARCHAR(32) NULL',
            'last_flutter' => 'INT(11) NULL',
            'theme' => 'INT(11) NOT NULL DEFAULT \'1\'',
        ], $tableOptions);

        $tableOptions = "";
        /* MYSQL */
        $this->createTable('{{%user_salt}}', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
            0 => 'PRIMARY KEY (`id`)',
            'user_id' => 'INT(11) NOT NULL',
            'salt' => 'VARCHAR(32) NOT NULL',
        ], $tableOptions);

        // FK and indices for post
        $this->addForeignKey('fk_topic_post', '{{%post}}', 'topic_id', '{{%topic}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_user_post', '{{%post}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_last_edited_user_post', '{{%post}}', 'last_edited_by_user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        // Yii Migrations does not support creating FULLTEXT indices, need to use a raw query.
        $this->execute('CREATE FULLTEXT INDEX `text` ON `post` (`text`)');
        $this->createIndex('created_on', '{{%post}}', 'created_on');

        // FK and indices for post_read
        $this->addForeignKey('fk_post_post_read', '{{%post_read}}', 'post_id', '{{%post}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_topic_post_read', '{{%post_read}}', 'topic_id', '{{%topic}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_user_post_read', '{{%post_read}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->createIndex('unique', '{{%post_read}}', ['user_id', 'topic_id', 'post_id'], true);

        // FK and indices for shout
        $this->addForeignKey('fk_user_shout', '{{%shout}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_to_user_shout', '{{%shout}}', 'to_user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->createIndex('created_on', '{{%shout}}', 'created_on');

        // FK and indices for subforum
        $this->addForeignKey('fk_category_subforum', '{{%subforum}}', 'category_id', '{{%category}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_topic_subforum', '{{%subforum}}', 'last_topic_id', '{{%topic}}', 'id', 'RESTRICT', 'RESTRICT' );

        // FK and indices for topic
        $this->addForeignKey('fk_post_topic', '{{%topic}}', 'last_post_id', '{{%post}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_subforum_topic', '{{%topic}}', 'subforum_id', '{{%subforum}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_user_topic', '{{%topic}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_last_post_user_topic', '{{%topic}}', 'last_post_user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->createIndex('last_post_on', '{{%topic}}', 'last_post_on');

        // FK and indices for user
        $this->addForeignKey('fk_banned_user_user', '{{%user}}', 'banned_by_user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->addForeignKey('fk_deleted_user_user', '{{%user}}', 'deleted_by_user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );

        // FK and indices for user_salt
        $this->addForeignKey('fk_user_user_salt', '{{%user_salt}}', 'user_id', '{{%user}}', 'id', 'RESTRICT', 'RESTRICT' );
        $this->createIndex('unique', '{{%user_salt}}', 'user_id', true);

    }

    public function down()
    {
        echo "m150220_195615_forum_core cannot be reverted.\n";

        return false;
    }
}
