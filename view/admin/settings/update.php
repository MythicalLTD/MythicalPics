<?php 
include(__DIR__ . '/../requirements/page.php');

$version = file_get_contents("https://raw.githubusercontent.com/MythicalLTD/mythicalpics/main/version");
$settingsVersion = trim($settings['version']);
$githubVersion = trim($version);
//SOON
?>