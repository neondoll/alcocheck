<?php

$db = require __DIR__ . '/test_db.php';
$params = require __DIR__ . '/params.php';

/**
 * Application configuration shared by all test types
 */
return [
    'aliases' => ['@bower' => '@vendor/bower-asset', '@npm' => '@vendor/npm-asset'],
    'basePath' => dirname(__DIR__),
    'components' => [
        'assetManager' => ['basePath' => __DIR__ . '/../web/assets'],
        'db' => $db,
        'mailer' => ['useFileTransport' => true],
        'request' => [
            'cookieValidationKey' => 'test',
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => ['domain' => 'localhost'],
            */
            'enableCsrfValidation' => false
        ],
        'urlManager' => ['showScriptName' => true],
        'user' => ['identityClass' => 'app\models\User']
    ],
    'id' => 'basic-tests',
    'language' => 'en-US',
    'params' => $params
];