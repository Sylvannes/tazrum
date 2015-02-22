<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;
    /* @var $this yii\web\View */
    $this->title = $subforum->name;
    $this->params['breadcrumbs'][] = ['label' => 'Subforum: ' . $this->title, 'url' => ['/site/subforum', 'id' => $subforum->id]];

    // TODO: The following functions can probably better be replaced with some sort of custom formatter that creates links out of such data.
    function renderTopicTitle (\app\models\Topic $topic) {
        return Html::a(Html::encode($topic->title), ['/topic', 'id' => $topic->id]);
    }

    function renderTopicAuthor (\app\models\Topic $topic) {
        $author = $topic->user;
        return Yii::$app->getView()->render('_username', ['user' => $author]);
    }

?>
<div class="site-index">
    <div class="body-content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">Subforum: <?= Html::encode($subforum->name) ?></h4>
            </div>
            <div class="panel-body bg-tazrum-gradient">
                <?php Pjax::begin([
                    'id' => 'topics-pjax'
                ]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{pager}\n{items}\n{pager}",
                    'columns' => [
                        ['attribute' => 'title', 'content' => 'renderTopicTitle'],
                        'created_on',
                        'last_post_on',
                        ['attribute' => 'user_id', 'content' => 'renderTopicAuthor'],
                    ],
                ]) ?>
                <?php Pjax::end(); ?>
             </div>
        </div>
    </div>
</div>
