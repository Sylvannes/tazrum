<?php

namespace app\controllers;

use app\models\Topic;

use \yii\web\Controller;
use \yii\data\ActiveDataProvider;
use \yii\web\HttpException;

class TopicController extends Controller {
	
	public function actionIndex ($id) {
		$viewData = array();

		$topic = Topic::findOne(['id' => $id]);
		if ($topic === NULL) {
			throw new HttpException(404, 'Dit topic kon niet worden gevonden.');
		}

		$dataProvider = new ActiveDataProvider([
			'query' => $topic->getPosts()->orderBy([
				'created_on' => SORT_ASC,
			])->with('user'),
			'pagination' => [
				'pageSize' => 20,
			],
		]);

		$viewData['topic'] = $topic;
		$viewData['dataProvider'] = $dataProvider;

		return $this->render('@app/views/site/topic', $viewData);
	}
	
}