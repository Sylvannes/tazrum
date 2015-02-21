<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Shout;
use yii\db\Expression;

/**
 * ShoutForm is the model that handles shouts.
 */
class ShoutForm extends Model {

    public $text;

    /**
     * @return array the validation rules.
     */
    public function rules () {
        return [
            ['text', 'required'],
            ['text', 'string', 'min' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels () {
        return [
            'text' => 'Shout'
        ];
    }

    public function create () {

        $shout = new Shout();
        $shout->user_id = Yii::$app->user->id;
        $shout->text = $this->text;
        $shout->created_on = new Expression('NOW()');

        return ($shout->validate() && $shout->save());

    }

}
