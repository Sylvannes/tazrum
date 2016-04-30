<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tazrum.post_read".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $topic_id
 * @property integer $post_id
 * @property string $created_on
 *
 * @property User $user
 * @property Topic $topic
 * @property Post $post
 */
class PostRead extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tazrum.post_read';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topic_id', 'post_id', 'created_on'], 'required'],
            [['user_id', 'topic_id', 'post_id'], 'integer'],
            [['created_on'], 'safe'],
            [['user_id', 'topic_id', 'post_id'], 'unique', 'targetAttribute' => ['user_id', 'topic_id', 'post_id'], 'message' => 'The combination of User ID, Topic ID and Post ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Gebruiker',
            'topic_id' => 'Topic',
            'post_id' => 'Post',
            'created_on' => 'Created On',
        ];
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
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
