<?php

namespace app\controllers;

use app\models\Subforum;

use \yii\web\Controller;
use \yii\data\ActiveDataProvider;
use \yii\web\HttpException;

class SubforumController extends Controller {

	public function actionIndex ($id) {
		$viewData = array();

		$subforum = Subforum::findOne(['id' => $id]);
		if ($subforum === NULL) {
			throw new HttpException(404, 'Dit subforum kon niet worden gevonden.');
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $subforum->getTopics()->with('user'),
			'sort' => ['defaultOrder' => ['sticky' => SORT_DESC, 'last_post_on' => SORT_DESC]],
			'pagination' => [
				'pageSize' => 20,
			],
		]);

		$viewData['subforum'] = $subforum;
		$viewData['dataProvider'] = $dataProvider;

		return $this->render('@app/views/site/subforum', $viewData);
	}

}