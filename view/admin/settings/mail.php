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
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `enable_smtp` = '" . $mail_enable . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_host` = '" . $mail_host . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_port` = '" . $mail_port . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_user` = '" . $mail_username . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_password` = '" . $mail_password . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_from` = '" . $mail_from_address . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_from_name` = '" . $mail_from_name . "' WHERE `atoropics_settings`.`id` = 1;");
    header('location: /admin/settings');
}
?>