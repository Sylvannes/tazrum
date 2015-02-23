<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tazrum4.shout".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $to_user_id
 * @property string $text
 * @property string $created_on
 *
 * @property User $user
 * @property User $toUser
 */
class Shout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tazrum4.shout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'to_user_id'], 'integer'],
            [['text'], 'required'],
            [['text'], 'string'],
            [['created_on'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave ($insert, $changedAttributes) {
        if ($insert) {
            // Update shout count of author
            $user = $this->getUser()->one();
            $user->shouts++;
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
            'user_id' => 'Auteur',
            'to_user_id' => 'Ontvanger',
            'text' => 'Text',
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
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }
}
