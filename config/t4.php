<?php

$xdg = new \XdgBaseDir\Xdg();
$homedir = $xdg->getHomeDir();

$configurationFile = '.t4';
$configurationFileContents = file_get_contents($homedir . '/' . $configurationFile);

$profileShortKey = $_SERVER['T4_PROFILE'] ?? 'default';

$profileChunks = explode("\n\n", $configurationFileContents);

$regex = "/(\[$profileShortKey\])/";

$profile = preg_grep($regex, $profileChunks);

$profile = array_values($profile);

$profile = $profile[0];

$lines = explode("\n", $profile);

$headings = [
    't4_url',
    't4_webapi',
    't4_token'
];

function getValue($lines, $key) {
    $value = preg_grep("/($key)/", $lines);
    $value = array_values($value);
    
    $value = preg_match("/$key=\"(.*)\"/", $value[0], $urlMatches);
    $value = $urlMatches[1];

    return $value;
}

$base = getValue($lines, 't4_url');
$webapi = getValue($lines, 't4_webapi');
$token = getValue($lines, 't4_token');

return [

    'base' => $base,

    'webapi' => $webapi,

    'token' => $token

];
