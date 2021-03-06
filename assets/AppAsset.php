<?php
namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/d3-tip.css'
    ];
    public $js = [
        // General code
        'js/navigation.js',
        'js/common.js',
        'js/scale.js',
        'js/svg.js',
        'js/table.js',
        'js/colvis.js',
        'js/export.js',
        'js/canvas-toBlob.js',

        // Experiments
        'js/experiments/intact.js',
        'js/experiments/mp.js',
        'js/experiments/roots.js',
        'js/experiments/default.js',
        'js/experiments/start.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\ModernizrAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\d3Asset',
        'app\assets\DatatablesAsset',
        'app\assets\DatatablesScrollerAsset',
        'app\assets\DatatablesYadcfAsset',
        'kartik\typeahead\TypeaheadAsset',
        'kartik\base\WidgetAsset',
        'kartik\slider\SliderAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\FilesaverAsset',
    ];
}
