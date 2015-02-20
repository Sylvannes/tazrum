<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;
    /* @var $this yii\web\View */
    $this->title = $user->name;
    $this->params['breadcrumbs'][] = ['label' => 'User: ' . $user->name, 'url' => ['/user', 'id' => $user->id]];
?>
<div class="site-index">
    <div class="body-content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">User: <?= Html::encode($user->name) ?></h4>
            </div>
            <div class="panel-body bg-tazrum-gradient">
                <?= DetailView::widget([
                    'model' => $user,
                    'attributes' => ['real_name', 'email', 'topics', 'posts', 'shouts', 'articles', 'achievement_points'],
                ]) ?>
             </div>
        </div>
    </div>
</div>
