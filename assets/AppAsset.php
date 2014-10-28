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
        'js/experiment.js',
        'js/navigation.js',
        'js/jquery.dataTables.yadcf.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\d3Asset',
        'app\assets\DatatablesAsset',
        'app\assets\DatatablesScrollerAsset',
        'app\assets\DatatablesYadcfAsset',
    ];
}
