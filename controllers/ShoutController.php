<?php

namespace app\controllers;

use Yii;
use \yii\web\Controller;
use yii\web\HttpException;
use \yii\data\ActiveDataProvider;

use app\models\Shout;
use app\models\forms\ShoutForm;

class ShoutController extends Controller {

    public function actionHistory () {

        $viewData = [];

        $shoutADP = new ActiveDataProvider([
            'query' => Shout::find()
                ->orderBy(['id' => SORT_DESC,])
                ->with('user')
                ->with('toUser'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $shoutForm = new ShoutForm();

        $viewData['shoutADP'] = $shoutADP;
        $viewData['shoutForm'] = $shoutForm;

        return $this->render('history', $viewData);

    }

    public function actionCreate ($from = '/site/index') {

        $shoutForm = new ShoutForm();
        if (!Yii::$app->request->getIsPost()) {
            throw new HttpException(400, 'Foutieve aanroep.');
        }

        switch ($from) {
            case '/site/index':
            case '/shout/history':
                break;
            default:
                throw new HttpException(400, 'Foutieve aanroep.');
        }

        $shoutForm->load(Yii::$app->request->post());
        if (!$shoutForm->validate() || !$shoutForm->create()) {
            Yii::$app->getSession()->setFlash('danger', 'De shout kon niet worden opgeslagen door een technisch probleem.');
        }

        return $this->redirect($from);

    }

    public function actionDelete ($id) {

        $shout = Shout::findOne(['id' => $id]);
        if ($shout === NULL) {
            throw new HttpException(404, 'Shout niet gevonden.');
        }

        $shout->delete();

        return $this->redirect('/site/index');

    }

}