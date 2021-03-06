<?php

return [
    'watch' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Server definition
    |--------------------------------------------------------------------------
    | Define a list of servers that your application will listen on,
    | the supported protocols are documented in https://github.com/walkor/Workerman
    |
    */
    'servers' => [
        [
            'name' => 'http://0.0.0.0:8081',
            'count' => 4 // Number of process
        ]
    ]
];
