<?php
    use yii\helpers\Html;
    use yii\widgets\ListView;
    /* @var $this yii\web\View */
    $topic->getSubforum()->one();
    $this->title = $topic->title;
    $this->params['breadcrumbs'][] = ['label' => 'Subforum: ' . $topic->subforum->name, 'url' => ['site/subforum', 'id' => $topic->subforum->id]];
    $this->params['breadcrumbs'][] = ['label' => 'Topic: ' . $this->title, 'url' => ['site/topic', 'id' => $topic->id]];
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
