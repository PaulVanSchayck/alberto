<?php
namespace app\assets;

use yii\web\AssetBundle;

class DatatablesAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/datatables/media';

    public $css = [
        'css/jquery.dataTables.min.css',
    ];
    public $js = [
        'js/jquery.dataTables.min.js',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}