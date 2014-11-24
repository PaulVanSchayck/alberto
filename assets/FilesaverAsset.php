<?php
namespace app\assets;

use yii\web\AssetBundle;

class FilesaverAsset extends AssetBundle
{
    public $sourcePath = '@vendor/eligrey/FileSaver.js';

    public $js = [
        'FileSaver.min.js',
    ];
}
