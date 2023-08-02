<?php 
require('../class/session.php');
$userdb = $conn->query("SELECT * FROM mythicalpics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();

if ($userdb['admin'] == "false") {
    header('location: /');
}


?>