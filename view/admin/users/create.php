<?php
include(__DIR__ . '/../requirements/page.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['create_user'])) {
    if ($settings['enable_smtp'] == "true") {
        $smtp_host = $settings['smtp_host'];
        $smtp_username = $settings['smtp_user'];
        $smtp_password = $settings['smtp_password'];
        $smtp_port = $settings['smtp_port'];
        $smtp_from = $settings['smtp_from'];
        $name = $settings['smtp_from_name'];
    }
    $length = 16;
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    $timestamp = time();
    $formatted_timestamp = date("HisdmY", $timestamp);
    $encoded_timestamp = base64_encode($formatted_timestamp);
    $key = $encoded_timestamp . implode($pass);
    $ip_addres = getclientip();
    $msg = "";
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    if ($settings['enable_smtp'] == "true") {
        $code = mysqli_real_escape_string($conn, md5(rand()));
    } else {
        $code = "null";
    }
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM atoropics_users WHERE email='" . $email . "'")) > 0) {
        $msg = "<div class='alert alert-danger'>" . $email . " - This email address is in use.</div>";
    }
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM atoropics_users WHERE username='" . $name . "'")) > 0) {
        $msg = "<div class='alert alert-danger'>" . $name . " - This username is in use.</div>";
    } else {
        $default = "https://www.gravatar.com/avatar/00000000000000000000000000000000";
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default);

        $sql = "INSERT INTO atoropics_users (username, avatar, email, password, code, last_ip, register_ip, api_key, admin, embed_title, embed_desc, embed_theme) VALUES ('" . $name . "', '{$grav_url}', '" . $email . "', '{$password}', '{$code}', '{$ip_addres}', '{$ip_addres}', '{$key}', 'false', 'AtoroShare', '#ffff' ,'A free image hosting service')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<div style='display: none;'>";
            //Create an instance; passing `true` enables exceptions
            if ($settings['enable_smtp'] == "true") {
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = 2; //Enable verbose debug output
                    $mail->isSMTP(); //Send using SMTP
                    $mail->Host = $smtp_host; //Set the SMTP server to send through
                    $mail->SMTPAuth = true; //Enable SMTP authentication
                    $mail->Username = $smtp_username; //SMTP username
                    $mail->Password = $smtp_password; //SMTP password
                    $mail->SMTPSecure = 'tls'; //Enable implicit TLS encryption
                    $mail->Port = $smtp_port; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom($smtp_from);
                    $mail->addAddress($email);

                    //Content
                    $mail->isHTML(true); //Set email format to HTML
                    $mail->Subject = 'no reply';
                    $mail->Body = 'Here is the verification link <b><a href="'.$settings["app_proto"]. $settings["app_url"].'/auth/login/?verification=' . $code . '">'.$settings["app_proto"]. $settings["app_url"].'/auth/login/?verification=' . $code . '</a></b>';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo . "";
                }
                echo "</div>";
                $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
            } else {
                echo "</div>";
                $msg = "<div class='alert alert-info'>Thanks for using " . $settings['app_name'] . "</div>";
                header('location: /admin/users');
            }

        } else {
            echo "</div>";
            $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-semi-dark"
  data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <?php include(__DIR__ . '/../requirements/head.php'); ?>
    <title>
        <?= $settings['app_name'] ?> | Users
    </title>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include(__DIR__ . '/../components/sidebar.php') ?>
            <div class="layout-page">
                <?php include(__DIR__ . '/../components/navbar.php') ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Users /</span> New</h4>
                        <?php
                        if (isset($_GET['e'])) {
                            ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <?= $_GET['e'] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <h5 class="card-header">Profile Details</h5>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <form action="/admin/users/new" method="POST">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="name" class="form-label">Username</label>
                                                    <input class="form-control" type="text" id="name"
                                                        name="name" value="" placeholder="nayskutzu" />
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="email" class="form-label">E-mail</label>
                                                    <input class="form-control" type="email" id="email" name="email"
                                                        value="" placeholder="me@nayskutzu.xyz" />
                                                </div>                    
                                                <div class="mb-3 col-md-6">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input class="form-control" type="password" id="password" name="password" value="" />
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <button type="submit" name="create_user" class="btn btn-primary me-2"
                                                    value="true">Create user</button>
                                                <a href="/admin/users/view" class="btn btn-label-secondary">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include(__DIR__ . '/../components/footer.php') ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    <?php include(__DIR__ . '/../requirements/footer.php') ?>
    <script src="../assets/js/pages-account-settings-account.js"></script>
</body>

</html>