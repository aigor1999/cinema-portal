<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=localhost;dbname=cinema_portal',
            'username' => 'postgres',
            'password' => '11111111',
            'charset' => 'utf8',
        ],
    ],
];
