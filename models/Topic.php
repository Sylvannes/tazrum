<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tazrum4.topic".
 *
 * @property integer $id
 * @property integer $subforum_id
 * @property string $title
 * @property integer $user_id
 * @property integer $sticky
 * @property integer $locked
 * @property integer $private
 * @property string $created_on
 * @property integer $last_post_id
 * @property integer $last_post_user_id
 * @property string $last_post_on
 *
 * @property Post[] $posts
 * @property Subforum[] $subforums
 * @property Post $lastPost
 * @property Subforum $subforum
 * @property User $user
 * @property User $lastPostUser
 */
class Topic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tazrum4.topic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subforum_id', 'user_id', 'sticky', 'locked', 'private', 'last_post_id', 'last_post_user_id'], 'integer'],
            [['user_id', 'created_on'], 'required'],
            [['created_on', 'last_post_on'], 'safe'],
            [['title'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave ($insert, $changedAttributes) {
        if ($insert) {
            // Update topic count of author
            $user = $this->getUser()->one();
            $user->topics++;
            $user->save();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subforum_id' => 'Subforum',
            'title' => 'Titel',
            'user_id' => 'Auteur',
            'sticky' => 'Sticky',
            'locked' => 'Locked',
            'private' => 'Private',
            'created_on' => 'Aangemaakt',
            'last_post_id' => 'Laatste post',
            'last_post_user_id' => 'Laatste post auteur',
            'last_post_on' => 'Last Post On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @deprecated This method does not make any sense. You never want to use it
     * and the name is also confusing. We should remove it.
     */
    public function getSubforums()
    {
        Yii::warning('Deprecated.', __METHOD__);
        return $this->hasMany(Subforum::className(), ['last_topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'last_post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubforum()
    {
        return $this->hasOne(Subforum::className(), ['id' => 'subforum_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastPostUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_post_user_id']);
    }

}
