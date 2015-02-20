<?php

namespace app\controllers;

use app\models\User;

use \yii\web\Controller;
use \yii\data\ActiveDataProvider;

class UserController extends Controller {
	
	public function actionIndex ($id) {
		$viewData = array();

		$user = User::findOne(['id' => $id]);
		if ($user === NULL) {
			throw new HttpException(404, 'Deze user kon niet worden gevonden.');
		}

		$viewData['user'] = $user;

		return $this->render('@app/views/site/user', $viewData);
	}
	
	public function actionList () {
		$viewData = array();

		$dataProvider = new ActiveDataProvider([
			'query' => User::find(),
			'pagination' => [
				'pageSize' => 20,
			],
		]);

		$viewData['dataProvider'] = $dataProvider;

		return $this->render('@app/views/site/memberlist', $viewData);
	}
	
}