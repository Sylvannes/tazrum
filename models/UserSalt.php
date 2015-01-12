<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tazrum4.user_salt".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $salt
 *
 * @property User $user
 */
class UserSalt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tazrum4.user_salt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['salt'], 'string', 'max' => 32],
            [['user_id'], 'unique']
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
            'salt' => 'Salt',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
