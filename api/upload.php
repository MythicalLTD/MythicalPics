<?php
header('Content-Type: application/json');
if (isset($_POST['api_key'])) {
    $query = "SELECT * FROM atoropics_users WHERE api_key='" . mysqli_real_escape_string($conn, $_POST['api_key']) . "'";
    $results = mysqli_query($conn, $query);
    if (mysqli_num_rows($results) == 1) {
        $userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_POST['api_key']) . "'")->fetch_array();
        $username = $userdb['username'];
        $desc = $userdb['embed_desc'];
        $desc_tit = $userdb['embed_title'];
        $embed_theme = $userdb['embed_theme'];
        $small_title = $userdb['embed_small_title'];
        
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $allowed = array("jpg", "jpeg", "png", "gif");

            if (in_array($ext, $allowed)) {
                if (!file_exists('../public/storage/uploads')) {
                    mkdir('uploads', 0777, true);
                }
                if (!file_exists('../public/storage/json')) {
                    mkdir('json', 0777, true);
                }
                $imgname_c = time();
                $new_name = $imgname_c . '.' . $ext;
                $upload_folder = '../public/storage/uploads/';
                $lockFile = fopen('lockfile-'.$imgname_c.'.lock', 'w');
                flock($lockFile, LOCK_EX);
                if (move_uploaded_file($file['tmp_name'], $upload_folder . $new_name)) {
                    $imgurl = $settings['app_proto'] . $settings['app_url'] . "/storage/uploads/" . $new_name;
                    $date = date("Y-m-d H:i:s");
                    $filesize = filesize($upload_folder . $new_name);
                    if ($filesize >= 1073741824) {
                        $filesize = round($filesize / 1073741824, 2) . ' GB';
                    } elseif ($filesize >= 1048576) {
                        $filesize = round($filesize / 1048576, 2) . ' MB';
                    } elseif ($filesize >= 1024) {
                        $filesize = round($filesize / 1024, 2) . ' KB';
                    } else {
                        $filesize = $filesize . ' bytes';
                    }
                    $data = array(
                        'url' => $imgurl,
                        'username' => $username,
                        'description' => $desc,
                        'title' => $desc_tit,
                        'theme' => $embed_theme,
                        'small_title' => $small_title,
                        'date' => $date,
                        'filesize' => $filesize
                    );
                    $json = json_encode($data, JSON_PRETTY_PRINT);
                    file_put_contents("../public/storage/json/" . $imgname_c . '.json', $json);
                    $query = "SELECT domain FROM atoropics_domains WHERE ownerkey = '" . $userdb['api_key'] . "'";
                    $result = $conn->query($query);
                    if ($result) {
                        $row = $result->fetch_assoc();
                        $domain = $row['domain'];
                        echo $settings['app_proto'] . $domain . "/i?i=" . $imgname_c;
                    } else {
                        echo $settings['app_proto'] . $settings['app_url'] . "/i?i=" . $imgname_c;
                    }
                    $apikey = mysqli_real_escape_string($conn, $_POST['api_key']);
                    $conn->query("INSERT INTO atoropics_imgs (name, owner_key, size, storage_folder) VALUES ('$imgname_c', '$apikey', '$filesize', '$imgurl')");

                    flock($lockFile, LOCK_UN);
                    fclose($lockFile);
                    unlink('lockfile-'.$imgname_c.'.lock');
                } else {
                    echo json_encode(array('status' => 'error', 'message' => 'Failed to upload file'));
                    $conn->close();
                    die();
                }
            } else {
                $conn->close();
                die(json_encode(array('status' => 'error', 'message' => 'Invalid file type')));
            }
        } else {
            $conn->close();
            die(json_encode(array('status' => 'error', 'message' => 'No file uploaded')));
        }
    } else {
        die(json_encode(array('status' => 'error', 'message' => 'Invalid API key')));
    }
} else {
    die(json_encode(array('status' => 'error', 'message' => 'No API key')));
}
?>
