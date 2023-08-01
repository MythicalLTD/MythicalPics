<?php
include(__DIR__ . '/../requirements/page.php');

if (isset($_GET['id'])) {
    if (!$_GET['id'] == "") {
        $user_query = "SELECT * FROM atoropics_users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            function deleteImagesAndPrintMessage($conn)
            {
                $query = "SELECT name FROM atoropics_imgs WHERE atoropics_imgs.id='".$_GET['id']."'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $name = $row['name'];
                        $formats = array("jpg", "jpeg", "png", "gif");
                        unlink("../public/storage/json/" . $name . '.json');
                        $conn->query("DELETE FROM atoropics_imgs WHERE `atoropics_imgs`.`name` = '".$name."'");
                        foreach ($formats as $format) {
                            $file_path = "../public/storage/uploads/" . $name . '.' . $format;
                            if (file_exists($file_path)) {
                                unlink($file_path);
                            } else {

                            }
                        }
                    }
                    mysqli_free_result($result);
                }
            }
            deleteImagesAndPrintMessage($conn);
            $conn->query("DELETE FROM `atoropics_users` WHERE `atoropics_users`.`id` = ".mysqli_real_escape_string($conn, $_GET['id'])."");
            $conn->close();
            header('location: /admin/users');
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