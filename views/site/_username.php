<?php
	use yii\helpers\Html;
	/**
	 * @var $this yii\web\View
	 * @var $user app\models\User
	 */
	
	$this->registerCss('.username { color: #0005bc;  }');
	$this->registerCss('.username.member { font-weight: bold; }');
	$this->registerCss('.username.submod { color: #118ecf; }');
	$this->registerCss('.username.mod { color: green; }');
	$this->registerCss('.username.admin { color: orange; }');
	
	$options = [];
	Html::addCssClass($options, 'username');
	$user->rank & 2 && Html::addCssClass($options, 'member'); // User objects without this flag could theoretically be guests
	$user->rank & 4 && Html::addCssClass($options, 'submod');
	$user->rank & 8 && Html::addCssClass($options, 'mod');
	$user->rank & 16 && Html::addCssClass($options, 'admin');

    if (isset($link) && !$link) {
        echo Html::tag('span', Html::encode($user->name), $options);
    }
    else {
        echo Html::a(Html::encode($user->name), ['/user', 'id' => $user->id], $options);
    }

?>