<?php
include(__DIR__ . '/../requirements/page.php');

if (isset($_GET['update_settings'])) {
    $mail_enable = $_GET['mail:enable'];
    $mail_host = $_GET['mail:host'];
    $mail_port = $_GET['mail:port'];
    $mail_username = $_GET['mail:username'];
    $mail_password = $_GET['mail:password'];
    $mail_from_address = $_GET['mail:from:address'];
    $mail_from_name = $_GET['mail:from:name'];
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `enable_smtp` = '" . $mail_enable . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `smtp_host` = '" . $mail_host . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `smtp_port` = '" . $mail_port . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `smtp_user` = '" . $mail_username . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `smtp_password` = '" . $mail_password . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `smtp_from` = '" . $mail_from_address . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `smtp_from_name` = '" . $mail_from_name . "' WHERE `mythicalpics_settings`.`id` = 1;");
    header('location: /admin/settings');
}
?>