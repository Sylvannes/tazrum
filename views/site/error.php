<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 class="panel-title">Je hebt de goden ongunstig gestemd</h4>
        </div>
        <div class="panel-body">
            Hun reactie is:
            <div class="alert alert-danger">
                <?= nl2br(Html::encode($message)) ?>
            </div>
        </div>
    </div>
</div>
