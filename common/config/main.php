<?php
return [
    'name' => 'Кинотеатр Блокбастер',
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=localhost;dbname=cinema_portal',
            'username' => 'postgres',
            'password' => '11111111',
            'charset' => 'utf8',
        ],
    ],
];
