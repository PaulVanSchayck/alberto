<?php
namespace app\assets;

use yii\web\AssetBundle;

class DatatablesYadcfAsset extends AssetBundle
{
    public $sourcePath = '@vendor/vedmack/yadcf/';

    public $css = [
        'jquery.dataTables.yadcf.css',
    ];
    public $js = [
        // The version provided as release is lagging some features, using the beta version separately
        //'jquery.dataTables.yadcf.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\DatatablesAsset',
    ];
}