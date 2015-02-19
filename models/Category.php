<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tazrum4.category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $order
 *
 * @property Subforum[] $subforums
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName () {
        return 'tazrum4.category';
    }

    /**
     * @inheritdoc
     */
    public function rules () {
        return [
            [['order'], 'integer'],
            [['name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels () {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubforums () {
        return $this->hasMany(Subforum::className(), ['category_id' => 'id']);
    }

}
