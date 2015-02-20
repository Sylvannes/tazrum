<?php

namespace app\controllers;

use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\User;
use app\models\LoginForm;
use app\models\Category;
use app\models\Shout;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex () {

        $viewData = array();

        $categories =
            Category::find()
            ->with('subforums.lastTopic.lastPost.postRead')
            ->with('subforums.lastTopic.lastPost.user')
            ->all()
        ;

        $shoutADP = new ActiveDataProvider([
            'query' => Shout::find()
                ->orderBy(['id' => SORT_DESC,])
                ->with('user')
                ->with('toUser'),
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        $activeUsers =
            User::find()
            ->where(['>=', 'last_login', new Expression('DATE_SUB(NOW(), INTERVAL 10 MINUTE)')])
            ->orderBy(['last_login' => SORT_DESC])
            ->all()
        ;

        $viewData['activeUsers'] = $activeUsers;
        $viewData['categories'] = $categories;
        $viewData['shoutADP'] = $shoutADP;

        return $this->render('index', $viewData);

    }

    public function actionMemberlist () {

        $viewData = array();

        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $viewData['dataProvider'] = $dataProvider;

        return $this->render('memberlist', $viewData);

    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
