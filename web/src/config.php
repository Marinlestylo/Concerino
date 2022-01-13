<?php

return [
    'database' => [
        'name' => getenv('DB_NAME'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'connection' => getenv('DB_CONNECTION') . ':host=' . getenv('DB_HOST'),
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];