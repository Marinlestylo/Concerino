<?php

return [
    'database' => [
        'name' => 'Concerino',
        'username' => 'postgres',
        'password' => 'admin',
        'connection' => 'pgsql:host=localhost',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];