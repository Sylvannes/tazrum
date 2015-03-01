<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\Pjax;
    use yii\widgets\ActiveForm;
    use app\components\ReversibleListView;
    use app\assets\ExpandedJQueryAsset;
    /* @var $this yii\web\View */
    $this->title = 'Shout geschiedenis';
    $this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/site/shouthistory'];
    ExpandedJQueryAsset::register($this);
    $this->registerJs('
        $("#shoutform-text").scrollTo();
    ');
?>
<div class="site-index">
    <div class="body-content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">Shout geschiedenis</h4>
            </div>
            <div class="panel-body bg-tazrum-gradient">
                <?php Pjax::begin([
                    'id' => 'shoutbox-pjax'
                ]); ?>
                <?= ReversibleListView::widget([
                    'dataProvider' => $shoutADP,
                    'id' => 'shoutbox',
                    'layout' => "{pager}\n{items}\n{pager}",
                    'itemView' => '/shout/_shout',
                    'viewParams' => [
                        'fullView' => true,
                    ],
                    'reverseSort' => true
                ]) ?>
                <?php Pjax::end(); ?>
                <?php $form = ActiveForm::begin([
                    'id' => 'ShoutForm',
                    'action' => Url::toRoute(['/shout/create', 'from' => '/shout/history']),
                    'options' => [
                        'class' => 'form-horizontal',
                        'method' => 'post',
                    ],
                    'fieldConfig' => [
                        'template' =>
                            "<div class=\"col-md-10\">{input}</div>" .
                            "<div class=\"col-md-2\">" .
                            Html::submitButton('Shout', ['class' => 'btn btn-success']) .
                            "</div>\n" .
                            "<div class=\"col-md-8\">{error}</div>",
                        'labelOptions' => ['class' => 'col-md-1 control-label'],
                    ],
                ]) ?>
                <?= $form->field($shoutForm, 'text') ?>
                <?php ActiveForm::end() ?>
             </div>
        </div>
    </div>
</div>
