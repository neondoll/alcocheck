<?php

$db = require __DIR__ . '/db.php';
$params = require __DIR__ . '/params.php';

$config = [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@mdm/admin' => '@app/widgets/yii2-admin',
        '@npm' => '@vendor/npm-asset',
        '@tests' => '@app/tests'
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'cache' => ['class' => 'yii\caching\FileCache'],
        'db' => $db,
        'log' => ['targets' => [['class' => 'yii\log\FileTarget', 'levels' => ['error', 'warning']]]]
    ],
    /*
    'controllerMap' => [
        'fixture' => [
            // Fixture generation command line.
            'class' => 'yii\faker\FixtureController'
        ]
    ],
    */
    'controllerNamespace' => 'app\commands',
    'id' => 'basic-console',
    'params' => $params
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;