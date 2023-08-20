<?php 
if (isset($_GET['auth_key'])) {
    $auth_key = mysqli_real_escape_string($conn, $_GET['auth_key']);
    if (!$auth_key == "") {
        $node_query = "SELECT * FROM mythicalpics_nodes WHERE auth_key = ?";
        $stmt = mysqli_prepare($conn, $node_query);
        mysqli_stmt_bind_param($stmt, "s", $auth_key);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            # CONTINUE
        } else {
            $rsp = array(
                "code" => 403,
                "error" => "The server understood the request, but it refuses to authorize it.",
                "message" => "We can't connect you since the auth key is not valid!"
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
        "message" => "Please provide a auth key"
    );
    http_response_code(400);
    die(json_encode($rsp, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}
?>