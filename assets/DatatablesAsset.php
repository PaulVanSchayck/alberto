<?php
namespace app\assets;

use yii\web\AssetBundle;

class DatatablesAsset extends AssetBundle
{
    public $sourcePath = '@vendor/datatables/datatables/media';

    public $css = [
        'css/jquery.dataTables.min.css',
    ];
    public $js = [
        'js/jquery.dataTables.js',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}