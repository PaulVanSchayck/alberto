<?php
namespace app\assets;

use yii\web\AssetBundle;

class FilesaverAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/filesaver.js',
        'js/canvas-toBlob.js'
    ];
}
