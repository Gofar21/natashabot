<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

use yii\rest\UrlRule;
use yii\web\Request;

$baseUrl = str_replace('api/web', 'api', (new Request)->getBaseUrl());
$frontendBaseUrl = str_replace('api/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-api',
    'language' => 'id-ID',
    'name' => 'Satu Data Kesehatan',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'homeUrl' => $baseUrl,
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => $baseUrl,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-e-data-sectoral',
                'httpOnly' => true
            ],
        ],
        // 'session' => [
        //     // this is the name of the session cookie used for login on the backend
        //     'name' => 'e-data-sectoral-2023',
        // ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            // 'baseUrl' => $baseUrl,
            'enableStrictParsing' => true,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => UrlRule::class,
                    'controller' => [
                        'produk',
                        'produk_kategori',
                        'perawatan',
                        'list'
                    ],
                    'pluralize' => false,
                    'only' => ['index', 'options'],
                    // 'except' => ['index', 'options', 'delete'],
                ],
            ],
        ],
        'urlFrontend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => $frontendBaseUrl,
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => array(
                'image/view/<idFile>/<filename>' => 'image/view',
                'image/resize/<width:\d+>/<height:\d+>/<idFile>/<filename>' => 'image/resize',
            ),
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:d/m/Y',
            'timeFormat' => 'php:H:i:s',
            'datetimeFormat' => 'php:d/m/Y H:i:s',
            'defaultTimeZone' => 'Asia/Jakarta',
            'timeZone' => 'Asia/Jakarta',
        ],
    ],
    'params' => $params,
];
