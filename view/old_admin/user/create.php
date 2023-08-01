<?php
require('../class/session.php');
$userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();

if ($userdb['admin'] == "false") {
    header('location: /');
}

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
                    $mail->Body = 'Here is the verification link <b><a href="' . $settings["app_proto"] . $settings["app_url"] . '/auth/login/?verification=' . $code . '">' . $settings["app_proto"] . $settings["app_url"] . '/auth/login/?verification=' . $code . '</a></b>';

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
                header('location: /oldadmin/users');
            }

        } else {
            echo "</div>";
            $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
        }
    }
}



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?= $settings['app_name'] ?> - New
    </title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $settings['app_logo'] ?>">
    <link rel="icon" type="image/png" href="<?= $settings['app_logo'] ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= $settings['app_logo'] ?>" sizes="16x16">
    <link rel="shortcut icon" href="<?= $settings['app_logo'] ?>">
    <link media="all" type="text/css" rel="stylesheet" href="/dist/vendor/select2/select2.min.css" />
    <link media="all" type="text/css" rel="stylesheet" href="/dist/vendor/bootstrap/bootstrap.min.css" />
    <link media="all" type="text/css" rel="stylesheet" href="/dist/vendor/adminlte/admin.min.css" />
    <link media="all" type="text/css" rel="stylesheet" href="/dist/vendor/adminlte/colors/skin-blue.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link media="all" type="text/css" rel="stylesheet" href="/dist/vendor/sweetalert/sweetalert.min.css" />
    <link media="all" type="text/css" rel="stylesheet" href="/dist/vendor/animate/animate.min.css" />
    <link media="all" type="text/css" rel="stylesheet" href="/dist/css/pterodactyl.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <style>
        .content-wrapper {
            padding-left: 0;
        }

        .container {
            display: flex;
        }

        .box {
            flex: 1;
            margin-right: 10px;
        }
    </style>
</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="/" class="logo">
                <span>
                    <?= $settings['app_name'] ?>
                </span>
            </a>
            <nav class="navbar navbar-static-top">
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="user-menu">
                            <a href="/admin">
                                <img src="<?= $userdb['avatar'] ?>" class="user-image" alt="User Image">
                                <span class="hidden-xs">
                                    <?= $userdb['username'] ?>
                                </span>
                            </a>
                        </li>
                        <li>
                        <li><a href="/dashboard" data-toggle="tooltip" data-placement="bottom"
                                title="Exit Admin Control"><i class="fa fa-server"></i></a></li>
                        </li>
                        <li>
                        <li><a href="/auth/logout" id="logoutButton" data-toggle="tooltip" data-placement="bottom"
                                title="Logout"><i class="fa fa-sign-out"></i></a></li>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <?php require(__DIR__ . '/../ui/navBar.php'); ?>
        <div class="content-wrapper" style="min-height: 868px;">
            <section class="content-header">
                <h1>Create User<small>Add a new user to the system.</small></h1>
                <ol class="breadcrumb">
                    <li><a href="/admin">Admin</a></li>
                    <li><a href="/oldadmin/users">Users</a></li>
                    <li class="active">Create</li>
                </ol>
            </section>
            <section class="content">
                <div class="row">
                    <?php
                    if (isset($_GET['e'])) {
                        ?>
                        <div class="col-xs-12">
                            <div class="alert alert-danger">
                                There was an error.<br><br>
                                <ul>
                                    <li>
                                        <?= $_GET['e'] ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                    </div>
                </div>
                <div class="row">
                    <form method="post">
                        <div class="col-md-6">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Identity</h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="email" class="control-label">Email</label>
                                        <div>
                                            <input type="email" autocomplete="off" name="email" value=""
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="control-label">Username</label>
                                        <div>
                                            <input type="text" autocomplete="off" name="name" value=""
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pass" class="control-label">Password</label>
                                        <div>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer text-center">
                                    <button type="submit" name="create_user" value="true"
                                        class="btn btn-success btn-sm">Create
                                        User</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <div class="pull-right small text-gray" style="margin-right:10px;margin-top:-7px;">
                <strong><i class="fa fa-fw fa-code-fork"></i></strong>
                <?= $settings['version'] ?><br />
                <strong><i class="fa fa-fw fa-clock-o"></i></strong> <span id="loadtime"></span>
            </div>
            Copyright &copy; 2022 - 2023 <a href="https://mythicalsystems.tech/">MythicalSystems</a>.
        </footer>
    </div>
    <script src="/dist/js/keyboard.polyfill.js" type="application/javascript"></script>
    <script>
        keyboardeventKeyPolyfill.polyfill();
    </script>

    <script src="/dist/vendor/jquery/jquery.min.js"></script>

    <script src="/dist/vendor/sweetalert/sweetalert.min.js"></script>

    <script src="/dist/vendor/bootstrap/bootstrap.min.js"></script>

    <script src="/dist/vendor/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="/dist/vendor/adminlte/app.min.js"></script>

    <script src="/dist/vendor/bootstrap-notify/bootstrap-notify.min.js"></script>

    <script src="/dist/vendor/select2/select2.full.min.js"></script>

    <script src="/dist/js/functions.js"></script>

    <script src="/dist/js/autocomplete.js" type="application/javascript"></script>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
    <script type="text/javascript">
        var before_loadtime = new Date().getTime();
        window.onload = Pageloadtime;
        function Pageloadtime() {
            var aftr_loadtime = new Date().getTime();
            // Time calculating in seconds
            pgloadtime = (aftr_loadtime - before_loadtime) / 1000

            document.getElementById("loadtime").innerHTML = pgloadtime + "s";
        }
    </script>
    <script>
        Swal.fire({
            title: 'Admin Area Error!',
            text: 'This admin area is EOL and won`t get updated anymore \nDo you want to continue',
            icon: 'error',
            confirmButtonText: 'Yes'
        });
    </script>
</body>

</html>