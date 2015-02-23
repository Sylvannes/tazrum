<?php

namespace app\modules\activity;

use Yii;
use yii\db\Expression;

class Module extends \yii\base\Module {

    public function init () {

        parent::init();

        if (!Yii::$app->user->isGuest) {
            register_shutdown_function(function(){
                Yii::trace('Shutdown function to update last_login executing.', __METHOD__);
                Yii::$app->user->identity->last_login = new Expression('NOW()');
                Yii::$app->user->identity->save();
            });
        }

    }

}