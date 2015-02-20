<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    /* @var $this yii\web\View */
    $this->title = $subforum->name;
    $this->params['breadcrumbs'][] = ['label' => 'Subforum: ' . $this->title, 'url' => ['/subforum', 'id' => $subforum->id]];

    // TODO: The following functions can probably better be replaced with some sort of custom formatter that creates links out of such data.
    function renderTopicTitle (\app\models\Topic $topic) {
        return Html::a(Html::encode($topic->title), ['/topic', 'id' => $topic->id]);
    }

    function renderTopicAuthor (\app\models\Topic $topic) {
        $author = $topic->user;
        return Html::a(Html::encode($author->name), ['/user', 'id' => $author->id]);
    }

?>
<div class="site-index">
    <div class="body-content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">Subforum: <?= Html::encode($subforum->name) ?></h4>
            </div>
            <div class="panel-body bg-tazrum-gradient">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['attribute' => 'title', 'content' => 'renderTopicTitle'],
                        'created_on',
                        'last_post_on',
                        ['attribute' => 'user_id', 'content' => 'renderTopicAuthor'],
                    ],
                ]) ?>
             </div>
        </div>
    </div>
</div>
