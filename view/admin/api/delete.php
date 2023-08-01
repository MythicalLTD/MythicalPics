<?php 
include(__DIR__ . '/../requirements/page.php');

if (isset($_GET['id'])) {
    $keyid = $_GET['id'];
    mysqli_query($conn, "DELETE FROM atoropics_apikeys WHERE `atoropics_apikeys`.`id` = " . $keyid . "");
    header('location: /newadmin/api');
}
else {
    header('location: /newadmin/api');
}
?>