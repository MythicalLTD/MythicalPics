<?php
include(__DIR__ . '/../api/base.php');
include(__DIR__ . '/base.php');
$uapi_key = mysqli_real_escape_string($conn, $_GET['api_key']);
if (isset($uapi_key)) {
    if (!$uapi_key == "") {
        $user_query = "SELECT * FROM mythicalpics_users WHERE api_key = ?";
        $stmt = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt, "s", $uapi_key);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $userdb = $conn->query("SELECT * FROM mythicalpics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_GET["api_key"]) . "'")->fetch_array();
            $rsp = array(
                "code" => 200,
                "error" => null,
                "message" => "Sure here you go",
                "main" => array(
                    "username" => $userdb['username'],
                    "email" => $userdb['email'],
                ),
                "embed" => array(
                    "title" => $userdb['embed_title'],
                    "small_title" => $userdb['embed_small_title'],
                    "description" => $userdb['embed_desc'],
                    "theme" => $userdb['embed_theme'],
                ),
                "upload" => array(
                    "domain" => $userdb['domain'],
                    "api_key" => $userdb['api_key'],
                )
            );
            http_response_code(200);
            die(json_encode($rsp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } else {
            $rsp = array(
                "code" => 403,
                "error" => "The server understood the request, but it refuses to authorize it.",
                "message" => "We can't give you information about that user because it does not exist in the database."
            );
            http_response_code(403);
            die(json_encode($rsp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    } else {
        $rsp = array(
            "code" => 400,
            "error" => "The server cannot understand the request due to a client error.",
            "message" => "Please provide a auth key"
        );
        http_response_code(400);
        die(json_encode($rsp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
} else {
    $rsp = array(
        "code" => 400,
        "error" => "The server cannot understand the request due to a client error.",
        "message" => "Please provide a user api key"
    );
    http_response_code(400);
    die(json_encode($rsp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}
?>