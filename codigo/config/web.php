<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$config = [
    'id' => 'basic',
    'name' => 'Inicio',
    'basePath' => dirname(__DIR__),
    'vendorPath' => implode(DIRECTORY_SEPARATOR, [dirname(dirname(__DIR__)), 'librerias', 'vendor']),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'EPSZ_DAW2_2024-25',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'busqueda' => 'site/busqueda',
                'comentarios' => 'comentarios/index',
                'comentarios/revisar-denuncias' => 'comentarios/revisar-denuncias',
                'registrar' => 'auth/registrar',
                'profile' => 'user/profile',
                'incidencias' => 'incidencia/index',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // Configuración adicional para el entorno de desarrollo
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
