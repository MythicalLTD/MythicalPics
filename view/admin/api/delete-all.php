<?php
header('Content-Type: application/json');
include(__DIR__ . '/../requirements/page.php');
if ($userdb['admin'] == "true") {
    $query2 = "SELECT name FROM mythicalpics_imgs";
    $results2 = mysqli_query($conn, $query2);
    
    if ($results2 !== false && mysqli_num_rows($results2) > 0) {
        while ($row = mysqli_fetch_assoc($results2)) {
            $imgid = $row['name'];
            $ext = pathinfo($imgid, PATHINFO_EXTENSION);
            $allowed = array("");
            if (in_array($ext, $allowed)) {
                $name = $imgid;
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

                $conn->query("DELETE FROM mythicalpics_imgs WHERE name = '$name'");
            }
        }
        echo json_encode(array('status' => 'success', 'message' => 'All images deleted successfully'));
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            header("Location: /admin");
        }
        http_response_code(200);
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'No images found in the database'));
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            header("Location: /admin");
        }
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
    if (isset($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: /");
    }
}
?>