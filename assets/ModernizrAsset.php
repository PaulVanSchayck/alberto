<?php
namespace app\assets;

use yii\web\AssetBundle;

class ModernizrAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/modernizr.js',
    ];
}
