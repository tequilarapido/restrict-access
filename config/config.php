<?php

return [

    'by_basic_auth' => [
        'enabled' => env('RESTRICT_ACCESS_BY_BASIC_AUTH_ENABLED', false),
        'username' => env('RESTRICT_ACCESS_BY_BASIC_AUTH_usename'),
        'password' => env('RESTRICT_ACCESS_BY_BASIC_AUTH_password'),
    ],

    'by_ip' => [
        'enabled' => env('RESTRICT_ACCESS_BY_IP_ENABLED', false),
        'except' => env('RESTRICT_ACCESS_BY_IP_ENABLED_EXCEPT')
    ],

];
