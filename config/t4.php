<?php

$xdg = new \XdgBaseDir\Xdg();
$homedir = $xdg->getHomeDir();

$configurationFile = '.t4';
$configurationFileContents = file_get_contents($homedir . '/' . $configurationFile);

$lines = explode("\n", $configurationFileContents);

$base = \Illuminate\Support\Str::between($lines[0], 'BASEURL="', '"');
$webapi = \Illuminate\Support\Str::between($lines[1], 'WEBAPI="', '"');
$token = \Illuminate\Support\Str::between($lines[2], 'TOKEN="', '"');

return [

    'base' => $base,

    'webapi' => $webapi,

    'token' => $token

];
