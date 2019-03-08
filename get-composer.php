#!/usr/bin/env php
<?php
# Adapted from https://getcomposer.org
#
$installerUrl = 'https://getcomposer.org/installer';
$installerSigUrl = 'https://composer.github.io/installer.sig';
$installerScript = 'composer-setup.php';

print("Downloading installer from {$installerUrl} ..." . PHP_EOL);
copy($installerUrl, $installerScript);

print("Getting hash from {$installerSigUrl} ... ");
$expectedHash = trim(file_get_contents($installerSigUrl));
print($expectedHash . PHP_EOL);

$installerHash = hash_file('SHA384', $installerScript);
if ("$installerHash" === "$expectedHash") {
    print('Installer verified; installing ...' . PHP_EOL);
    include $installerScript;
} else {
    print("Installer corrupt, hash does not match: $installerHash; aborting." . PHP_EOL);
}

unlink($installerScript);
