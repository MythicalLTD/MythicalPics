<?php 
include(__DIR__ . '/../requirements/page.php');

if (isset($_GET['id'])) {
    $keyid = mysqli_real_escape_string($conn,$_GET['id']);
    mysqli_query($conn, "DELETE FROM mythicalpics_apikeys WHERE `mythicalpics_apikeys`.`id` = " . $keyid . "");
    header('location: /admin/api');
}
else {
    header('location: /admin/api');
}
?>