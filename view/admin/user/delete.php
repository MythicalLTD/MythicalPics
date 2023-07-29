<?php
require('../class/session.php');
function pass()
{
    return null;
}
$userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();

if ($userdb['admin'] == "false") {
    header('location: /');
}

if (isset($_GET['id'])) {
    if (!$_GET['id'] == "") {
        $user_query = "SELECT * FROM atoropics_users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {

            $conn->query("DELETE FROM `atoropics_users` WHERE `atoropics_users`.`id` = ".mysqli_real_escape_string($conn, $_GET['id'])."");
        }
    } else {
        header('location: /admin/users');
        exit();
    }
} else {
    header('location: /admin/users');
    exit();
}
?>