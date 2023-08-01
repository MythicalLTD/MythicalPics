<?php 
include(__DIR__ . '/../requirements/page.php');

$version = file_get_contents("https://raw.githubusercontent.com/MythicalLTD/mythicalpics/main/version");
$settingsVersion = trim($settings['version']);
$githubVersion = trim($version);
//SOON
$update = "cd /var/www/MythicalPics && git pull";
$update_status = ssh2_exec($connection, $update);
ssh2_disconnect($connection);
header('location: /admin/settings');
?>