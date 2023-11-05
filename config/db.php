<?php

use yii\db\Connection;

return [
    'class'             => Connection::class,
    'dsn'               => 'mysql:host=127.0.0.1;dbname=YOUR_DB_NAME',
    'username'          => 'root',
    'password'          => '',
    'charset'           => 'utf8',
    'on afterOpen'      => static function ($event) {
        $event->sender->createCommand("SET time_zone = '" . date('P') . "'")->execute();
        $event->sender->createCommand("SET sql_mode = '';")->execute();
    },
    'enableSchemaCache' => true,
];
