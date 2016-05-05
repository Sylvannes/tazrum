<?php

namespace app\models;

use Yii;
use yii\base\ErrorException;


/**
 * This is the model class for table "tazrum.user".
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

    const ROLE_ADMIN = 'Administrator';
    const ROLE_MOD = 'Moderator';

    public $authKey;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tazrum.user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['posts', 'shouts', 'topics', 'polls', 'articles', 'shoutrpg_wins', 'shoutrpg_losses', 'hide_email', 'banned_by_user_id', 'deleted_by_user_id', 'achievement_points', 'private_messages', 'last_flutter', 'theme'], 'integer'],
            [['birth_date', 'last_login', 'registered_on', 'banned_on', 'deleted_on'], 'safe'],
            [['last_ip', 'registered_on', 'name', 'email', 'rank'], 'required'],
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
            'password' => 'Wachtwoord',
            'auth_key' => 'Auth key',
            'email' => 'E-mail adres',
            'location' => 'Woonplaats',
            'posts' => 'Posts',
            'shouts' => 'Shouts',
            'topics' => 'Topics',
            'polls' => 'Polls',
            'articles' => 'Artikelen',
            'shoutrpg_wins' => 'ShoutRPG Wins',
            'shoutrpg_losses' => 'ShoutRPG Losses',
            'hide_email' => 'Verberg e-mail adres',
            'birth_date' => 'Geboortedatum',
            'last_login' => 'Laatste login',
            'last_ip' => 'Laatste IP',
            'registered_on' => 'Geregistreerd op',
            'banned_on' => 'Gebanned op',
            'deleted_on' => 'Verwijderd op',
            'banned_by_user_id' => 'Gebanned door',
            'deleted_by_user_id' => 'Verwijderd door',
            'status' => 'Status',
            'activation_code' => 'Activatiecode',
            'modules' => 'Modules',
            'achievement_points' => 'Achievement punten',
            'avatar' => 'Avatar',
            'signature' => 'Signature',
            'profile_text' => 'Profieltekst',
            'forum_location' => 'Forum locatie',
            'real_name' => 'Echte naam',
            'gender' => 'Geslacht',
            'private_messages' => 'Priveberichten',
            'custom_status' => 'Custom status',
            'last_flutter' => 'Laatste flutter',
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

        return ($lastPostRead instanceof \app\models\PostRead);

    }

    public function getCustomStatus () {

        if ($this->posts >= 500) {
            return $this->custom_status;
        } else if ($this->posts >= 400) {
            return 'Whiskeydrinker';
        } else if ($this->posts >= 300) {
            return 'Vodkadrinker';
        } else if ($this->posts >= 200) {
            return 'Rumdrinker';
        } else if ($this->posts >= 100) {
            return 'Wijndrinker';
        } else if ($this->posts >= 50) {
            return 'Bierdrinker';
        } else if ($this->posts >= 10) {
            return 'Shandydrinker';
        } else {
            return 'Slootwaterdrinker';
        }

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShouts()
    {
        return $this->hasMany(Shout::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedUsers()
    {
        return $this->hasMany(User::className(), ['deleted_by_user_id' => 'id']);
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
    public function getBannedUsers()
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
     * @return \yii\db\ActiveQuery
     */
    public function getSalt()
    {
        return $this->hasOne(UserSalt::className(), ['user_id' => 'id']);
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

    /**
     * Retrieve the roles this user has and compare against a given role name
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
        return array_key_exists($role, $roles);
    }

}
