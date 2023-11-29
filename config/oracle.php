<?php


/*
return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = xe) (SID = xe)))'),
        'host'           => env('DB_HOST', 'localhost'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', ''),
        'username'       => env('DB_USERNAME', 'prevision'),
        'password'       => env('DB_PASSWORD', 'previsiondesa'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];
*/


return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.0.213)(PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = SIRLFEDS.SEGUROSLAFE.COM) (SID = SIRLFEDS.SEGUROSLAFE.COM)))'),
        'host'           => env('DB_HOST', '192.168.0.213'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', ''),
        'username'       => env('DB_USERNAME', 'prevision'),
        'password'       => env('DB_PASSWORD', 'previ1234'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];
