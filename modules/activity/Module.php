<?php

    namespace app\modules\activity;

    use Yii;
    use yii\db\Expression;

    class Module extends \yii\base\Module {

        public function init () {

            parent::init();

            if (!Yii::$app->user->isGuest) {
                Yii::$app->user->identity->last_login = new Expression('NOW()');
                Yii::$app->user->identity->save();
            }

        }

    }