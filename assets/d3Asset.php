<?php
namespace app\assets;

use yii\web\AssetBundle;

class d3Asset extends AssetBundle
{
    public $sourcePath = '@vendor/mbostock/d3';

    public $js = [
        'd3.js'
    ];
}
