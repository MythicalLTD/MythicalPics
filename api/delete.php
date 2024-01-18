<?php
header('Content-Type: application/json');
if (isset($_GET['owner_key']) && isset($_GET['imgid'])) {
    $owner_key = mysqli_real_escape_string($conn, $_GET['owner_key']);
    $imgid = mysqli_real_escape_string($conn, $_GET['imgid']);
    $query = "SELECT * FROM mythicalpics_users WHERE api_key='$owner_key'";
    $results = mysqli_query($conn, $query);
    if (mysqli_num_rows($results) == 1) {
        $query2 = "SELECT name FROM mythicalpics_imgs WHERE owner_key='$owner_key' AND name='$imgid' ";
        $results2 = mysqli_query($conn, $query2);
        if (mysqli_num_rows($results2) == 1) {
            $ext = pathinfo($_GET['imgid'], PATHINFO_EXTENSION);
            $allowed = array("");
            if (in_array($ext, $allowed)) {
                $name = $_GET['imgid'];
                $formats = array("jpg", "jpeg", "png", "gif");
                $delete_folder = '../public/storage/uploads/';
                unlink("../public/storage/json/".$name.'.json');
                foreach ($formats as $format) {
                    $file_path = "../public/storage/uploads/" . $name . '.' . $format;
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    } else {

                    }
                }
                echo($ext);
                $apikey = $_GET['owner_key'];
                $conn->query("DELETE FROM mythicalpics_imgs WHERE name = '$name' AND owner_key = '$apikey'");
                echo json_encode(array('status' => 'success', 'message' => 'Image deleted successfully'));
                http_response_code(200);
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Invalid image id'));
            }
        }else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid image id'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid API key'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
}
?>
