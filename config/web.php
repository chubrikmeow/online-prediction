<?php

use himiklab\yii2\recaptcha\ReCaptchaConfig;

Yii::setAlias('@root', dirname(__DIR__));

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'zgDohrwxdQRUnorLOABpTMe6ZYZn7owt',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'suffix'          => '/',
            'rules'           => [
                '/'                     => 'site/index',
                'sign-up/'              => 'auth/sign-up',
                'sign-in/'              => 'auth/sign-in',
                'logout/'               => 'auth/logout',
            ]
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'reCaptcha' => [
            'class' => ReCaptchaConfig::class,
            // https://www.google.com/recaptcha
            'siteKeyV2' => 'YOUR_SITE_KEY',
            'secretV2' => 'YOUR_SECRET',
        ],
        'db' => $db,
    ],
    'params' => $params,
];

return $config;
