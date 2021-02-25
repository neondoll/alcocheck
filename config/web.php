<?php

$db = require __DIR__ . '/db.php';
$params = require __DIR__ . '/params.php';
$routes = require __DIR__ . '/router.php';

$config = [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@mdm/admin' => '@app/widgets/yii2-admin',
        '@npm' => '@vendor/npm-asset'
    ],
    'as access' => [
        'allowActions' => [
            'admin/*',
            'debug/*',
            'site/*'
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ],
        'class' => 'mdm\admin\components\AccessControl'
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => false
                //'yii\bootstrap4\BootstrapPluginAsset' => false,
                //'yii\web\JqueryAsset' => false
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager' // or use 'yii\rbac\DbManager'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache'
        ],
        'db' => $db,
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true
        ],
        'log' => [
            'targets' => [[
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning']
            ]],
            'traceLevel' => YII_DEBUG ? 3 : 0
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3W_d3T6Ddh2qRllqRlps1XXAlgW9vAFr',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => $routes,
            'showScriptName' => false
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityClass' => 'app\models\User'
        ]
    ],
    'defaultRoute' => 'site/login',
    'id' => 'basic',
    'language' => 'ru-RU',
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController'
                ]
            ],
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/admin.php'
        ]
    ],
    'params' => $params
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
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