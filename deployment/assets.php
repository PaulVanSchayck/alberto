<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot','/opt/app/web');
Yii::setAlias('@web', '/');

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'uglifyjs {from} -o {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'cleancss {from} -o {to}',
    // The list of asset bundles to compress:
    'bundles' => [
         'app\assets\AppAsset',
    ],
    // Asset bundle for compression output:
    'targets' => [
        'all' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/min',
            'baseUrl' => '@web/min',
            'js' => 'all-{hash}.js',
            'css' => 'all-{hash}.css',
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/min',
        'baseUrl' => '@web/min',
        'bundles' => [
            'yii\web\JqueryAsset' => [
                'js' => ['jquery.min.js']
            ],
        ]
    ],
];