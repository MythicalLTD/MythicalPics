<?php 
include(__DIR__ . '/../requirements/page.php');

if (isset($_GET['key'])) {
    $keyname = mysqli_real_escape_string($conn,$_GET['name']);
    $formatted_timestamp = date("HisdmY", $timestamp);
    $encoded_timestamp = base64_encode($formatted_timestamp);
    $api_key = "mythicalpics_" .$encoded_timestamp. generateRandomString(45);
    mysqli_query($conn, "INSERT INTO `atoropics_apikeys` (`api_key`, `owner_api_key`, `name`) VALUES ('" . $api_key . "', '" . $_COOKIE["api_key"] . "', '" . $keyname . "')");
    header('location: /newadmin/api');
}
else {
    header('location: /newadmin/api'); 
}
?>