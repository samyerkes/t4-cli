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

function isConfigurationLine($value)
{
    // If it's just an empty line return false, we don't need it.
    if ($value == "") return false;

    // if it matches the profile heading syntax return false, we don't need it.
    $regex = "/\[.*\]/";
    $matchesProfileHeadingSyntax = preg_match($regex, $value);
    return $matchesProfileHeadingSyntax ? false : true;
}

function getValue($line, $key) {
    $regex = "/^{$key}=\"(.*)\"$/";
    $value = preg_match($regex, $line, $urlMatches);
    $value = $urlMatches[1];
    return $value;
}

$lines = array_filter($lines, 'isConfigurationLine');

list($base, $webapi, $token) = array_map('getValue', $lines, $headings);

return [

    'base' => $base,

    'webapi' => $webapi,

    'token' => $token

];
