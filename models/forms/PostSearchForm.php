<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;

/**
 * ShoutForm is the model that handles shouts.
 */
class PostSearchForm extends Model {

    public $query;

    /**
     * @return array the validation rules.
     */
    public function rules () {
        return [
            ['query', 'required'],
            ['query', 'string', 'min' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels () {
        return [
            'query' => 'Zoekopdracht'
        ];
    }

    public function search () {

    }

}
