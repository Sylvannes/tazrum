<?php
    use yii\helpers\Html;
    use yii\helpers\HtmlPurifier;
?>
<div class="panel panel-shout">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2">
                <div class="btn-group">
                    <button type="button" class="btn btn-shout dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?= Yii::$app->formatter->asTime($model->created_on) ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Quote</a></li>
                        <li><a href="#">Verwijderen</a></li>
                    </ul>
                </div>
                <?= $this->render('_username', ['user' => $model->user]) ?>:
            </div>
            <div class="col-md-10">
                <?= HtmlPurifier::process($model->text) ?>
            </div>
        </div>
    </div>
</div>