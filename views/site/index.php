<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use app\components\ReversibleListView;
    use app\models\Topic;
    use app\models\PostRead;
    use yii\widgets\Pjax;
    use yii\widgets\ActiveForm;
    /* @var $this yii\web\View */
    $this->title = 'TaZrum';
    $this->registerJs('
        setInterval(function(){
            $.pjax.reload({container:"#shoutbox-pjax"});
        }, 5000);
        $(document).on("pjax:beforeReplace", function(event, contents, options) {
            // TODO: Figure out a way to cancel pjax replace if content is the same.
        })
        $("#shoutform-text").focus();
    ');
?>
<div class="site-index">
    <div class="body-content">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">Shoutbox</h4>
                </div>
                <div class="panel-body bg-tazrum-gradient">
                    <?php Pjax::begin([
                        'id' => 'shoutbox-pjax'
                    ]); ?>
                    <?= ReversibleListView::widget([
                        'dataProvider' => $shoutADP,
                        'id' => 'shoutbox',
                        'layout' => "{items}\n{pager}",
                        'itemView' => '_shout',
                        'viewParams' => [
                            'fullView' => true,
                        ],
                        'reverseSort' => true
                    ]) ?>
                    <?php Pjax::end(); ?>
                    <?php $form = ActiveForm::begin([
                        'id' => 'ShoutForm',
                        'options' => [
                            'class' => 'form-horizontal',
                            'method' => 'post',
                        ],
                        'fieldConfig' => [
                            'template' => "<div class=\"col-md-11\">{input}</div><div class=\"col-md-1\">" . Html::submitButton('Shout', ['class' => 'btn btn-success']) . "</div>\n<div class=\"col-md-8\">{error}</div>",
                            'labelOptions' => ['class' => 'col-md-1 control-label'],
                        ],
                    ]) ?>
                    <?= $form->field($shoutForm, 'text') ?>
                    <?php ActiveForm::end() ?>
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
                                        <a href="<?= Url::toRoute(['/subforum', 'id' => $subforum->id]) ?>">
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
                                            <a href="<?= Url::toRoute(['/topic', 'id' => $subforum->lastTopic->id]) ?>">
                                                <div class="panel panel-<?= $postClass ?>">
                                                    <div class="panel-heading"><?= Html::encode($subforum->lastTopic->title) ?></div>
                                                    <div class="panel-body">
                                                        <?= $this->render('_username', ['user' => $subforum->lastTopic->lastPost->user, 'link' => false]) /*Html::encode($subforum->lastTopic->lastPost->user->name)*/ ?>,
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
            <?php
            foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                echo '<div class="alert alert-' . Html::encode($key) . '">' . Html::encode($message) . '</div>';
            }
            ?>
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
