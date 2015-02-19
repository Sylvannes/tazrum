<?php

namespace app\controllers;

use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\data\ActiveDataProvider;
use app\models\User;
use yii\web\HttpException;

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
            \app\models\Category::find()
            ->with('subforums')
            ->all();

        $shoutADP = new ActiveDataProvider([
            'query' => \app\models\Shout::find()
                ->orderBy(['id' => SORT_DESC,])
                ->with('user')
                ->with('toUser'),
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        $activeUsers =
            \app\models\User::find()
            ->where(['>=', 'last_login', new Expression('DATE_SUB(NOW(), INTERVAL 10 MINUTE)')])
            ->orderBy(['last_login' => SORT_DESC])
            ->all()
        ;

        $viewData['activeUsers'] = $activeUsers;
        $viewData['categories'] = $categories;
        $viewData['shoutADP'] = $shoutADP;

        return $this->render('index', $viewData);

    }

    public function actionSubforum ($id) {

        $viewData = array();

        $subforum = \app\models\Subforum::findOne(['id' => $id]);
        if ($subforum === NULL) {
            throw new HttpException(404, 'Dit subforum kon niet worden gevonden.');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $subforum->getTopics()->with('user'),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => ['defaultOrder' => ['sticky' => SORT_DESC, 'last_post_on' => SORT_DESC]]
        ]);

        $viewData['subforum'] = $subforum;
        $viewData['dataProvider'] = $dataProvider;

        return $this->render('subforum', $viewData);

    }

    public function actionTopic ($id) {

        $viewData = array();

        $topic = \app\models\Topic::findOne(['id' => $id]);
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

        return $this->render('topic', $viewData);

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
