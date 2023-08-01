<?php 
include(__DIR__ . '/../requirements/page.php');

if (isset($_GET['key'])) {
    $keyname = mysqli_real_escape_string($conn,$_GET['name']);
    $length = 16;
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $length; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
    }
    $timestamp = time();
    $formatted_timestamp = date("HisdmY", $timestamp);
    $encoded_timestamp = base64_encode($formatted_timestamp);
    $api_key = "mythicalpics_" .$encoded_timestamp. generateRandomString(45);
    mysqli_query($conn, "INSERT INTO `atoropics_apikeys` (`api_key`, `owner_api_key`, `name`) VALUES ('" . $api_key . "', '" . $_COOKIE["api_key"] . "', '" . $keyname . "')");
    header('location: /admin/api');
}
else {
    header('location: /admin/api'); 
}
?>