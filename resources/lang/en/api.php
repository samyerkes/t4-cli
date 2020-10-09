<?php

return [
    'channel' => [
        'index' => '/channel'
    ],
    'contenttype' => [
        'index' => '/contenttype'
    ],
    'group' => [
        'index' => '/group',
        'show' => '/group/:group',
        'user' => '/group/user/:user',
    ],
    'keys' => [
        'index' => '/apikey/list'
    ],
    'profile' => '/profile',
    'schedule' => [
        'index' => '/schedule'
    ],
    'transfer' => [
        'index' => '/transfer'
    ],
    'user' => [
        'index' => '/user'
    ]
];