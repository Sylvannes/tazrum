<?php

namespace app\assets;

use yii\web\AssetBundle;

class MaterializeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/flesler/jquery.scrollto';
    public $css = [
        '//cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css',
    ];
    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js'
    ];
    public $depends = [
    ];
}