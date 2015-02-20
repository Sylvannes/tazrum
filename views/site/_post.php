<?php
    use yii\helpers\Html;
    use yii\helpers\HtmlPurifier;
?>
<div class="panel panel-post">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-1 text-center">
                <?= $this->render('_username', ['user' => $model->user]) ?>
            </div>
            <div class="col-md-9">
                <?= Yii::$app->formatter->asDatetime($model->created_on, 'long') ?>
            </div>
            <div class="col-md-2 text-right">
                <div class="btn-group" role="group" aria-label="">
                    <button type="button" class="btn btn-post">Quote</button>
                    <button type="button" class="btn btn-post">Permalink</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-1 text-center">
                <?= Html::img('http://www.tazrum.nl/' . $model->user->avatar) ?><br />
                <em><?= Html::encode($model->user->getCustomStatus()) ?></em>
            </div>
            <div class="col-md-11">
                <?= HtmlPurifier::process($model->text) ?>
            </div>
        </div>
    </div>
    <?php
        if ($model->user->signature) {
            ?>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                        <?= HtmlPurifier::process($model->user->signature) ?>
                    </div>
                </div>
            </div>
            <?php
        }
    ?>
</div>