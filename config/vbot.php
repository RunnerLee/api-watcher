<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */


$path = __DIR__ . '/../storage/vbot/';

return [
    'url' => env('APP_URL'),

    'path'     => $path,

    'tuling' => [
        'api_key' => env('TULING_API_KEY'),
        'user_id' => env('TULING_USER_ID'),
    ],

    'swoole'  => [
        'status' => true,
        'ip'     => env('VBOT_SERVER_IP'),
        'port'   => env('VBOT_SERVER_PORT'),
    ],

    'download' => [
        'image'         => false,
        'voice'         => false,
        'video'         => false,
        'emoticon'      => false,
        'file'          => false,
        'emoticon_path' => $path . 'emoticons',
    ],

    'console' => [
        'output'  => true,
        'message' => true,
    ],

    'log'      => [
        'level'         => 'debug',
        'permission'    => 0777,
        'system'        => $path . 'log',
        'message'       => $path . 'log',
    ],

    'cache' => [
        'default' => 'redis',
        'stores'  => [
            'file' => [
                'driver' => 'file',
                'path'   => $path.'cache',
            ],
            'redis' => [
                'driver'     => 'redis',
                'connection' => 'default',
            ],
        ],
    ],

    'extension' => [
        'admin' => [
            'remark'   => '',
            'nickname' => '',
        ],
        'runner_demo' => [
        ],
    ],

    'contact' => [
        'groups' => [
            'team' => env('VBOT_NOTICE_USER'),
        ],
    ],

    'database' => [
        'default' => 'mysql',
        'redis' => [
            'default' => [
                'host' => env('REDIS_HOST', '127.0.0.1'),
                'password' => env('REDIS_PASSWORD', null),
                'port' => env('REDIS_PORT', 6379),
                'database' => env('REDIS_DATABASE', 4),
            ],
        ],
        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '3306'),
                'database' => env('DB', 'api_watcher'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', ''),
                'unix_socket' => '',
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],
        ],
    ],
];