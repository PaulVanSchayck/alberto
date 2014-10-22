<?php
namespace app\assets;

use yii\web\AssetBundle;

class DatatablesScrollerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/datatables-scroller/';

    public $css = [
        'css/dataTables.scroller.css',
    ];
    public $js = [
        'js/dataTables.scroller.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\DatatablesAsset',
    ];
}