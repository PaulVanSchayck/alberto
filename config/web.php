<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'wYrgaxhY9HM-POfbuMe6MV3iaED7Iw6l',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'assetManager' => [
            'bundles' => require(__DIR__ . '/' . (YII_ENV_DEV ? 'assets-dev.php' : 'assets-prod.php')),
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [
                'site/tab/<exp:.+>' => 'site/tab',
                'gene/autocomplete/<q:.+>' => 'gene/autocomplete',
                'gene/data/<exp:.+>' => 'gene/data',
                'gene/export/<exp:.+>' => 'gene/export',
            ]
        ]
    ],
    'params' => $params,
];

if (! YII_ENV_DEV) {
    // See: https://github.com/kartik-v/yii2-widgets/issues/137
    $config['components']['assetManager']['bundles']['kartik\\typeahead\\TypeaheadAsset'] = [
        'sourcePath' => kartik\base\AssetBundle::EMPTY_PATH,
        'js' => kartik\base\AssetBundle::EMPTY_ASSET,
        'css' => kartik\base\AssetBundle::EMPTY_ASSET,
    ];
    $config['components']['assetManager']['bundles']['kartik\\base\\WidgetAsset'] = [
        'sourcePath' => kartik\base\AssetBundle::EMPTY_PATH,
        'css' => kartik\base\AssetBundle::EMPTY_ASSET,
    ];
}

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' =>  ['127.0.0.1', '::1', '172.*']
    ];
}

return $config;
