<?php

namespace app\modules\activity;

use Yii;
use yii\db\Expression;

class Module extends \yii\base\Module {

    public function init () {

        parent::init();

        register_shutdown_function(function(){
            if (!Yii::$app->user->isGuest) {
                Yii::trace('Shutdown function to update last_login executing.', __METHOD__);
                Yii::$app->user->identity->last_login = new Expression('NOW()');
                Yii::$app->user->identity->save();
            }
        });

    }

}