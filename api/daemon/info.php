<?php 
include(__DIR__.'/../base.php');
include(__DIR__.'/base.php');
$rsp = array(
    "code" => 200,
    "error" => null,
    "message" => "Sure here you go",
    "settings" => array(
        "name" => $settings['app_name'],
        "logo" => $settings['app_logo'],
        "maintenance" => $settings['app_maintenance'],
        "protocol" => $settings['app_proto'],
        "main_url" => $settings['app_url']
    ),
    "mythicalpics" => array(
        "name" => "MythicalPics",
        "version" => $settings['version'],
        "debug" => $_ENV['DEBUG_MODE']
    )
);
http_response_code(200);
die(json_encode($rsp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
?>