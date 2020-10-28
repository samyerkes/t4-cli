<?php

return [
    'about' => [
        'index' => '/about/general'
    ],
    'channel' => [
        'index' => '/channel'
    ],
    'contenttype' => [
        'index' => '/contenttype'
    ],
    'group' => [
        'index' => '/group',
        'show' => '/group/:group',
    ],
    'layout' => [
        'index' => '/pageLayout'
    ],
    'keys' => [
        'index' => '/apikey/list'
    ],
    'navigation' => [
        'index' => '/navigation'
    ],
    'profile' => '/profile',
    'schedule' => [
        'index' => '/schedule'
    ],
    'transfer' => [
        'index' => '/transfer'
    ],
    'user' => [
        'index' => '/user',
        'show' => '/user/:user',
        'groups' => '/group/user/:user'
    ]
];