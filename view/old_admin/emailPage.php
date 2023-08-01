<?php
require('../class/session.php');

$userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();

if ($userdb['admin'] == "false") {
    header('location: /');
}

if (isset($_POST['saveEmailSettings'])) {
    $mail_enable = $_POST['mail:enable'];
    $mail_host = $_POST['mail:host'];
    $mail_port = $_POST['mail:port'];
    $mail_username = $_POST['mail:username'];
    $mail_password = $_POST['mail:password'];
    $mail_from_address = $_POST['mail:from:address'];
    $mail_from_name = $_POST['mail:from:name'];
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `enable_smtp` = '" . $mail_enable . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_host` = '" . $mail_host . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_port` = '" . $mail_port . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_user` = '" . $mail_username . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_password` = '" . $mail_password . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_from` = '" . $mail_from_address . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `smtp_from_name` = '" . $mail_from_name . "' WHERE `atoropics_settings`.`id` = 1;");
    header('location: /oldadmin/settings/mail');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?= $settings['app_name'] ?> - Settings
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
        <?php require('ui/navBar.php'); ?>
        <div class="content-wrapper" style="min-height: 888px;">
            <section class="content-header">
                <h1>Mail Settings<small>Configure how AtoroPics should handle sending emails.</small></h1>
                <ol class="breadcrumb">
                    <li><a href="/admin">Admin</a></li>
                    <li class="active">Settings</li>
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
                    <div class="col-xs-12">
                        <div class="nav-tabs-custom nav-tabs-floating">
                            <ul class="nav nav-tabs">
                                <li class=""><a href="/oldadmin/settings">General</a></li>
                                <li class="active"><a href="/oldadmin/settings/mail">Mail</a></li>
                                <li><a href="/oldadmin/settings/advanced">Advanced</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Email Settings</h3>
                                </div>
                                <form method="POST">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label class="control-label">SMTP</label>
                                                <div>
                                                    <?php
                                                    if ($settings['enable_smtp'] == "true") {
                                                        ?>
                                                        <select name="mail:enable" class="form-control">
                                                            <option value="true">Enable</option>
                                                            <option value="false">Disable</option>
                                                        </select>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <select name="mail:enable" class="form-control">
                                                            <option value="false">Disable</option>
                                                            <option value="true">Enable</option>
                                                        </select>
                                                        <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label">SMTP Host</label>
                                                <div>
                                                    <input required="" type="text" class="form-control" name="mail:host"
                                                        value="<?= $settings['smtp_host'] ?>">
                                                    <p class="text-muted small">Enter the SMTP server
                                                        address that mail should be sent through.</p>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label">SMTP Port</label>
                                                <div>
                                                    <input required="" type="number" class="form-control"
                                                        name="mail:port" value="<?= $settings['smtp_port'] ?>">
                                                    <p class="text-muted small">Enter the SMTP server
                                                        port that mail should be sent through.</p>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Username <span
                                                        class="field-optional"></span></label>
                                                <div>
                                                    <input type="text" class="form-control" name="mail:username"
                                                        value="<?= $settings['smtp_user'] ?>">
                                                    <p class="text-muted small">The username to use when
                                                        connecting to the SMTP server.</p>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Password <span
                                                        class="field-optional"></span></label>
                                                <div>
                                                    <input type="password" value="<?= $settings['smtp_password'] ?>"
                                                        class="form-control" name="mail:password">
                                                    <p class="text-muted small">The password to use in
                                                        conjunction with the SMTP username.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <hr>
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Mail From</label>
                                                <div>
                                                    <input required="" type="email" class="form-control"
                                                        name="mail:from:address" value="<?= $settings['smtp_from'] ?>">
                                                    <p class="text-muted small">Enter an email address
                                                        that all outgoing emails will originate from.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Mail From Name <span
                                                        class="field-optional"></span></label>
                                                <div>
                                                    <input type="text" class="form-control" name="mail:from:name"
                                                        value="<?= $settings['smtp_from_name'] ?>">
                                                    <p class="text-muted small">The name that emails
                                                        should appear to come from.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <div class="pull-right">
                                            <button type="submit" id="saveButton" name="saveEmailSettings"
                                                class="btn btn-sm btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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