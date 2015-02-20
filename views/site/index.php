<?php
    use yii\helpers\Html;
    use yii\widgets\ListView;
    use app\models\Topic;
    use app\models\PostRead;
    /* @var $this yii\web\View */
    $this->title = 'TaZrum';
?>
<div class="site-index">
    <div class="body-content">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">Shoutbox</h4>
                </div>
                <div class="panel-body bg-tazrum-gradient">
                    <?= ListView::widget([
                        'dataProvider' => $shoutADP,
                        'itemView' => '_shout',
                        'viewParams' => [
                            'fullView' => true,
                        ],
                    ]) ?>
                </div>
            </div>
            <?php
                foreach ($categories as $category) {
                    ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4 class="panel-title"><?= Html::encode($category->name) ?></h4>
                        </div>
                        <div class="panel-body bg-tazrum-gradient">
                            <div class="row">
                                <?php
                                foreach ($category->subforums as $subforum) {
                                    ?>
                                    <div class="col-md-8">
                                        <a href="/site/subforum?id=<?= Html::encode($subforum->id) ?>">
                                            <div class="panel panel-subforum">
                                                <div class="panel-heading"><?= Html::encode($subforum->name) ?></div>
                                                <div class="panel-body"><small><?= Html::encode($subforum->desc) ?></small></div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        if ($subforum->lastTopic instanceof Topic) {
                                            $postClass = 'topic-unread';
                                            if ($subforum->lastTopic->lastPost->postRead instanceof PostRead) {
                                                $postClass = 'topic-read';
                                            }
                                            ?>
                                            <a href="/site/topic?id=<?= Html::encode($subforum->lastTopic->id) ?>">
                                                <div class="panel panel-<?= $postClass ?>">
                                                    <div class="panel-heading"><?= Html::encode($subforum->lastTopic->title) ?></div>
                                                    <div class="panel-body">
                                                        <?= Html::encode($subforum->lastTopic->lastPost->user->name) ?>,
                                                        <?= Yii::$app->formatter->asRelativeTime($subforum->lastTopic->last_post_on) ?>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php
                                        }
                                        else {
                                            ?>
                                            <div class="alert alert-warning" role="alert">Geen topics.</div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">Actieve gebruikers</h4>
                </div>
                <div class="panel-body bg-tazrum-gradient">
                    <?php
                        $i = 0;
                        foreach ($activeUsers as $user) {
                            ++$i;
                            echo Html::encode($user->name) . ($i < count($activeUsers) ? ', ' : '');
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
