<?php
namespace app\assets;

use yii\web\AssetBundle;

class DatatablesColVisAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/datatables-colvis/';

    public $css = [
        'css/dataTables.colVis.css',
    ];
    public $js = [
        'js/dataTables.colVis.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\DatatablesAsset',
    ];
}