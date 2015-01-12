<?php
    use yii\helpers\Html;
    use yii\widgets\ListView;
    /* @var $this yii\web\View */
    $topic->getSubforum()->one();
    $this->title = 'Topic: ' . $topic->title;
    $this->params['breadcrumbs'][] = 'Subforum: ' . Html::a(Html::encode($topic->subforum->name), ['site/subforum', 'id' => $topic->subforum->id]);
    $this->params['breadcrumbs'][] = 'Topic: ' . Html::a(Html::encode($topic->title), ['site/topic', 'id' => $topic->id]);
?>
<div class="site-index">
    <div class="body-content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">Topic: <?= Html::encode($topic->title) ?></h4>
            </div>
            <div class="panel-body bg-tazrum-gradient">
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_post',
                    'viewParams' => [
                        'fullView' => true,
                    ],
                ]) ?>
             </div>
        </div>
    </div>
</div>
