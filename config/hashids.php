<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish
    | to use as your default connection for all work.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections
    | as you would like.
    |
    */

    'connections' => [

        'main' => [
            'salt' => env('HASHIDS_SALT', 'your-secret-salt'),
            'length' => 6,
            'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        ],

        'alternative' => [
            'salt' => env('HASHIDS_SALT_ALT', 'another-secret-salt'),
            'length' => 8,
            'alphabet' => 'abcdefghijklmnopqrstuvwxyz'
        ],

    ],

];

