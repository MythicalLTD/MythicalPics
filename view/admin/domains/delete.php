<?php 
include(__DIR__ . '/../requirements/page.php');

if (isset($_GET['id'])) {
    $keyid = mysqli_real_escape_string($conn,$_GET['id']);
    mysqli_query($conn, "DELETE FROM mythicalpics_domains WHERE `mythicalpics_domains`.`id` = " . $keyid . "");
    header('location: /admin/domains');
}
else {
    header('location: /admin/domains');
}
?>