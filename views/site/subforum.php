<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    /* @var $this yii\web\View */
    $this->title = 'Subforum: ' . Html::encode($subforum->name);
    $this->params['breadcrumbs'][] = 'Subforum: ' . Html::a(Html::encode($subforum->name), ['site/subforum', 'id' => $subforum->id]);
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
                ]) ?>
             </div>
        </div>
    </div>
</div>
