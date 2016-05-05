<?php

use app\models\User;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $user app\models\User
 */

$this->registerCss('.username { color: #0005bc;  }');
$this->registerCss('.username.member { font-weight: bold; }');
$this->registerCss('.username.mod { color: green; }');
$this->registerCss('.username.admin { color: orange; }');

$options = [];
Html::addCssClass($options, 'username');
if ($user->hasRole(User::ROLE_ADMIN)) {
    Html::addCssClass($options, 'admin');
}
elseif ($user->hasRole(User::ROLE_MOD)) {
    Html::addCssClass($options, 'mod');
}
else {
    Html::addCssClass($options, 'member');
}

if (isset($link) && !$link) {
    echo Html::tag('span', Html::encode($user->name), $options);
}
else {
    echo Html::a(Html::encode($user->name), ['/user', 'id' => $user->id], $options);
}

?>