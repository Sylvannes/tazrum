<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tazrum4.post".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $topic_id
 * @property string $text
 * @property string $created_on
 * @property integer $edits
 * @property integer $last_edited_by_user_id
 * @property string $last_edited_on
 * @property integer $fluttered
 *
 * @property Topic $topic
 * @property User $user
 * @property User $lastEditedByUser
 * @property Topic[] $topics
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tazrum4.post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'topic_id', 'text', 'created_on'], 'required'],
            [['user_id', 'topic_id', 'edits', 'last_edited_by_user_id', 'fluttered'], 'integer'],
            [['text'], 'string'],
            [['created_on', 'last_edited_on'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'topic_id' => 'Topic ID',
            'text' => 'Text',
            'created_on' => 'Created On',
            'edits' => 'Edits',
            'last_edited_by_user_id' => 'Last Edited By User ID',
            'last_edited_on' => 'Last Edited On',
            'fluttered' => 'Fluttered',
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastEditedByUser()
    {
        return $this->hasOne(User::className(), ['id' => 'last_edited_by_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['last_post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostRead () {
        return
            $this->hasOne(PostRead::className(), ['post_id' => 'id'])
            ->onCondition(['post_read.user_id' => Yii::$app->user->id])
        ;
    }
}
