<?php 
#                      AtoroTech NOTE
# ! WARRNING DO NOT SET THIS AS YOUR WEBSERVER HOME DIR !
# ! PLEASE DO NOT USE THIS AS YOUR HOME DIR USERS CAN DOWNLOAD !
# ! YOUR .env FILE WITH ALL YOUR IMPORTANT INFO LIKE SSH AND MYSQL !
# ! PLEASE USE the /public DIR THANKS FOR UNDERSTANDING !
#

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env');
$dotenv->load();
if ($_ENV['DEBUG_MODE'] == "true") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(null);
}
$conn = new mysqli($_ENV['MySQL_HOST'] . ':' .$_ENV['MySQL_PORT'], $_ENV['MySQL_USER'], $_ENV['MySQL_PASSWORD'], $_ENV['MySQL_DATABASE']);
$settings = $conn->query("SELECT * FROM atoropics_settings")->fetch_array();

//
// CONNECT TO LOCAL MACHINE
//
$connection = ssh2_connect($_ENV['SSH_IP'], $_ENV['SSH_PORT']);
if (!$connection) {
    exit('SSH connection failed.');
}

if (!ssh2_auth_password($connection, $_ENV['SSH_USER'], $_ENV['SSH_PASSWORD'])) {
    exit('SSH authentication failed.');
}

//
// GET USER IP
//
function getclientip() {
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)) { $ip = $client; }
    elseif(filter_var($forward, FILTER_VALIDATE_IP)) { $ip = $forward; }
    else { $ip = $remote; }

    return $ip;
}

//
// SEND MESSAGE TO WEBHOOK
//
function logClient($message) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env');
    $dotenv->load();
    $conn = new mysqli($_ENV['MySQL_HOST'] . ':' .$_ENV['MySQL_PORT'], $_ENV['MySQL_USER'], $_ENV['MySQL_PASSWORD'], $_ENV['MySQL_DATABASE']);
    $settings = $conn->query("SELECT * FROM settings")->fetch_array();
    $url = $settings['discord_webhook'];
    
    $headers = [ 'Content-Type: application/json; charset=utf-8' ];
    $POST = ['content' => $message ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
    $response = curl_exec($ch);
}

//
// GENERATE STRING
//
function generateRandomString($length) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = mt_rand(0, strlen($characters) - 1);
        $string .= $characters[$randomIndex];
    }

    return $string;
}
?>