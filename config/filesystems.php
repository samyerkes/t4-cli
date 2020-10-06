<?php

$xdg = new \XdgBaseDir\Xdg();
$homedir = $xdg->getHomeDir();

return [
    'default' => 'local',

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'home' => [
            'driver' => 'local',
            'root' => $homedir,
        ],

    ],
];