<?php

namespace app\controllers;

use app\models\forms\SearchForm;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use app\models\User;
use app\models\LoginForm;
use app\models\Category;
use app\models\Shout;
use app\models\Topic;
use app\models\forms\ShoutForm;
use app\models\forms\PostSearchForm;

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

        $viewData = [];

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
                'pageSize' => 8,
            ],
        ]);
        $shoutForm = new ShoutForm();

        $activeUsers =
            User::find()
            ->where(['>=', 'last_login', new Expression('DATE_SUB(NOW(), INTERVAL 10 MINUTE)')])
            ->orderBy(['last_login' => SORT_DESC])
            ->all()
        ;

        $postSearchForm = new PostSearchForm();

        $unreadTopicADP = new ActiveDataProvider([
            'query' => Topic::find()
                ->with('subforum')
                ->where([
                    'not exists', (new Query)
                        ->select('id')
                        ->from('post_read')
                        ->where([
                            'post_read.topic_id' => 'topic.id',
                            'post_read.post_id' => 'topic.last_post_id',
                            'post_read.user_id' => Yii::$app->user->id,
                        ])
                    ,
                ])
                ->andWhere(['private' => 0])
                ->orderBy(['last_post_on' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $recentTopicADP = new ActiveDataProvider([
            'query' => Topic::find()
                ->with('subforum')
                ->where(['private' => 0])
                ->orderBy(['last_post_on' => SORT_DESC,])
                ->limit(10),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $viewData['activeUsers'] = $activeUsers;
        $viewData['categories'] = $categories;
        $viewData['shoutADP'] = $shoutADP;
        $viewData['shoutForm'] = $shoutForm;
        $viewData['postSearchForm'] = $postSearchForm;
        $viewData['unreadTopicADP'] = $unreadTopicADP;
        $viewData['recentTopicADP'] = $recentTopicADP;

        return $this->render('index', $viewData);

    }

    public function actionMemberlist () {

        $viewData = [];

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
