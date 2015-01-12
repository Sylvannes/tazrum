<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;


/**
 * This is the model class for table "tazrum4.user".
 *
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $location
 * @property integer $posts
 * @property integer $shouts
 * @property integer $topics
 * @property integer $polls
 * @property integer $articles
 * @property integer $shoutrpg_wins
 * @property integer $shoutrpg_losses
 * @property integer $hide_email
 * @property string $birth_date
 * @property string $last_login
 * @property string $last_ip
 * @property string $registered_on
 * @property string $banned_on
 * @property string $deleted_on
 * @property integer $banned_by_user_id
 * @property integer $deleted_by_user_id
 * @property string $status
 * @property string $activation_code
 * @property string $modules
 * @property integer $achievement_points
 * @property string $avatar
 * @property string $signature
 * @property string $profile_text
 * @property string $forum_location
 * @property string $real_name
 * @property string $gender
 * @property integer $private_messages
 * @property string $custom_status
 * @property integer $last_flutter
 * @property integer $theme
 *
 * @property Post[] $posts
 * @property Topic[] $topics
 * @property User $deletedByUser
 * @property User[] $users
 * @property User $bannedByUser
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tazrum4.user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['posts', 'shouts', 'topics', 'polls', 'articles', 'shoutrpg_wins', 'shoutrpg_losses', 'hide_email', 'banned_by_user_id', 'deleted_by_user_id', 'achievement_points', 'private_messages', 'last_flutter', 'theme'], 'integer'],
            [['birth_date', 'last_login', 'registered_on', 'banned_on', 'deleted_on'], 'safe'],
            [['last_ip', 'registered_on', 'forum_location'], 'required'],
            [['status', 'signature', 'profile_text', 'forum_location', 'gender'], 'string'],
            [['name'], 'string', 'max' => 20],
            [['password', 'auth_key', 'activation_code', 'custom_status'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 150],
            [['location', 'modules', 'avatar', 'real_name'], 'string', 'max' => 128],
            [['last_ip'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Gebruikersnaam',
            'password' => 'Passwd',
            'auth_key' => 'Auth key',
            'email' => 'E-Mail',
            'location' => 'Locatie',
            'posts' => 'Posts',
            'shouts' => 'Shouts',
            'topics' => 'Topics',
            'polls' => 'Polls',
            'articles' => 'Artikelen',
            'shoutrpg_wins' => 'ShoutRPG Wins',
            'shoutrpg_losses' => 'ShoutRPG Losses',
            'hide_email' => 'Hide Email',
            'birth_date' => 'Geboortedatum',
            'last_login' => 'Last Login',
            'last_ip' => 'Last Ip',
            'registered_on' => 'Geregistreerd op',
            'banned_on' => 'Banned On',
            'deleted_on' => 'Deleted On',
            'banned_by_user_id' => 'Banned By User ID',
            'deleted_by_user_id' => 'Deleted By User ID',
            'status' => 'Status',
            'activation_code' => 'Activation Code',
            'modules' => 'Modules',
            'achievement_points' => 'Achievement Points',
            'avatar' => 'Avatar',
            'signature' => 'Signature',
            'profile_text' => 'Profile Text',
            'forum_location' => 'Forum Location',
            'real_name' => 'Real Name',
            'gender' => 'Gender',
            'private_messages' => 'Private Messages',
            'custom_status' => 'Custom Status',
            'last_flutter' => 'Last Flutter',
            'theme' => 'Theme',
        ];
    }

    public function hasReadPost (\app\models\Post $post) {

        $lastPostRead =
            \app\models\PostRead::find()
            ->where([
                'user_id' => $this->id,
                'topic_id' => $post->topic_id,
                'post_id' => $post->id
            ])->one();
        ;

        return ($lastPostRead instanceof \app\models\PostRead);

    }

    public function getCustomStatus () {

        if ($this->posts >= 500) {
            return $this->custom_status;
        }
        elseif ($this->posts < 10) {
            return 'Slootwaterdrinker';
        }
        elseif ($this->posts >= 10 && $this->posts < 50) {
            return 'Shandydrinker';
        }
        elseif ($this->posts >= 50 && $this->posts < 100) {
            return 'Bierdrinker';
        }
        elseif ($this->posts >= 100 && $this->posts < 200) {
            return 'Wijndrinker';
        }
        elseif ($this->posts >= 200 && $this->posts < 300) {
            return 'Rumdrinker';
        }
        elseif ($this->posts >= 300 && $this->posts < 400) {
            return 'Vodkadrinker';
        }
        elseif ($this->posts >= 400) {
            return 'Whiskeydrinker';
        }

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['last_edited_by_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['last_post_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'deleted_by_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['banned_by_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBannedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'banned_by_user_id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['name' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {

        $userSalt = \app\models\UserSalt::findOne(['user_id' => $this->id]);
        if ($userSalt === NULL) {
            throw new ErrorException('Kon geen UserSalt vinden voor deze gebruiker.');
        }

        return md5($password . $userSalt->salt) === $this->password;

    }

}
