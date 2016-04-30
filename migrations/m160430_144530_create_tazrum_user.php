<?php

use yii\db\Migration;

/**
 * Handles the creation for table `tazrum.user`.
 */
class m160430_144530_create_tazrum_user extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{tazrum}}.{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull(),
            'password' => $this->string(40)->notNull()->comment('Salted and encrypted password.'),
            'auth_key' => $this->string(32)->notNull(),
            'email' => $this->string(150)->notNull(),
            'location' => $this->string(128),
            'posts' => $this->integer()->notNull()->defaultValue(0)->comment('Amount of posts this user has made.'),
            'shouts' => $this->integer()->notNull()->defaultValue(0)->comment('Amount of shouts this user has made.'),
            'topics' => $this->integer()->notNull()->defaultValue(0)->comment('Amount of topics this user has made.'),
            'polls' => $this->integer()->notNull()->defaultValue(0)->comment('Amount of polls this user has mode.'),
            'articles' => $this->integer()->notNull()->defaultValue(0)->comment('Amount of wiki articles this user has made.'),
            'private_messages' => $this->integer()->notNull()->defaultValue(0)->comment('Amount of private messages this user has made.'),
            'shoutrpg_wins' => $this->integer()->notNull()->defaultValue(0)->comment('Amount of shout RPG wins this user has.'),
            'shoutrpg_losses' => $this->integer()->notNull()->defaultValue(0)->comment('Amount of shout RPG losses this user has.'),
            'hide_email' => $this->boolean()->notNull()->defaultValue(true)->comment('Whether to hide the email address of this user.'),
            'birth_date' => $this->date(),
            'last_login' => $this->dateTime(),
            'last_ip' => $this->string(39),
            'registered_on' => $this->dateTime()->notNull(),
            'banned_on' => $this->dateTime()->comment('Datetime this user was last banned from the forum.'),
            'deleted_on' => $this->dateTime()->comment('Datetime this user was (soft) deleted from the forum.'),
            'banned_by_user_id' => $this->integer()->comment('User that last banned this user from the forum.'),
            'deleted_by_user_id' => $this->integer()->comment('User that last (soft) deleted this user from the forum.'),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('Status code of the user, e.g. inactive, active, banned, deleted, etc...'),
            'activation_code' => $this->string(40)->notNull()->comment('Hash of the user activation link sent upon registration.'),
            'achievement_points' => $this->integer()->notNull()->defaultValue(0)->comment('The amount of achievement points this user has gathered.'),
            'avatar' => $this->string(128),
            'signature' => $this->text()->comment('Signature showing up beneath posts this user makes.'),
            'profile_text' => $this->text(),
            'forum_location' => $this->text()->comment('Last forum location this user has visited.'),
            'real_name' => $this->string(128),
            'gender' => $this->smallInteger(1)->comment('Gender code of the user, e.g. male, female, anything in between, etc...'),
            'custom_status' => $this->string(32),
            'last_fluttered_post_id' => $this->integer()->comment('The last post this user has submitted to Flutterby.'),
        ]);

        $this->addForeignKey('fk_banned_user_user', '{{tazrum}}.{{%user}}', 'banned_by_user_id', '{{tazrum}}.{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
        $this->addForeignKey('fk_deleted_user_user', '{{tazrum}}.{{%user}}', 'deleted_by_user_id', '{{tazrum}}.{{%user}}', 'id', 'RESTRICT', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_deleted_user_user', '{{tazrum}}.{{%user}}');
        $this->dropForeignKey('fk_banned_user_user', '{{tazrum}}.{{%user}}');

        $this->dropTable('{{tazrum}}.{{%user}}');
    }
}
