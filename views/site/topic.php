<?php
    use yii\helpers\Html;
    use yii\widgets\ListView;
    /* @var $this yii\web\View */
    $topic->getSubforum()->one();
    $this->title = $topic->title;
    $this->params['breadcrumbs'][] = ['label' => 'Subforum: ' . $topic->subforum->name, 'url' => ['/subforum', 'id' => $topic->subforum->id]];
    $this->params['breadcrumbs'][] = ['label' => 'Topic: ' . $this->title, 'url' => ['/topic', 'id' => $topic->id]];
?>
<div class="site-index">
    <div class="body-content">
        <div class="panel panel-tazrum">
            <div class="panel-heading">
                <h4 class="panel-title">Topic: <?= Html::encode($topic->title) ?></h4>
            </div>
            <div class="panel-body bg-tazrum-gradient">
                <?= ListView::widget([
                    'layout' => "{pager}\n{items}\n{pager}",
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
