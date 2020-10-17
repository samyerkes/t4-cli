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

// if there are empty values in the lines array remove them
$lines = array_filter($lines);

$headings = [
    '', // this is for the profile heading.
    't4_url',
    't4_webapi',
    't4_token'
];

function isProfileHeading($value)
{
    $regex = "/\[.*\]/";
    return preg_match($regex, $value);
}

function getValue($line, $key) {
    // if it matches a profile name return false
    if (isProfileHeading($line)) return false;

    $regex = "/^{$key}=\"(.*)\"$/";
    $value = preg_match($regex, $line, $urlMatches);
    $value = $urlMatches[1];
    return $value;
}

list($profileName, $base, $webapi, $token) = array_map('getValue', $lines, $headings);

return [

    'base' => $base,

    'webapi' => $webapi,

    'token' => $token

];
