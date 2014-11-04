<?php
namespace app\assets;

use yii\web\AssetBundle;

class d3Asset extends AssetBundle
{
    public $sourcePath = '@vendor/bower';

    public $js = [
        'd3/d3.min.js',
        'd3-tip/index.js'
    ];
}
