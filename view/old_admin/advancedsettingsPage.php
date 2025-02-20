<?php
require('../class/session.php');

$userdb = $conn->query("SELECT * FROM mythicalpics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();

if ($userdb['admin'] == "false") {
    header('location: /');
}

if (isset($_POST['saveadvsettings'])) {
    $app_maintenance = $_POST['atoropics:settings:maintenance'];
    $app_url = $_POST['atoropics:settings:url'];
    $app_registration = $_POST['registration:enabled'];
    $app_recaptcha = $_POST['recaptcha:enabled'];
    $app_recaptcha_site_key = $_POST['recaptcha:website_key'];
    $app_recaptcha_secret_key = $_POST['recaptcha:secret_key'];
    $app_discord_invite = $_POST['discord:server:invite'];
    $app_discord_webhook = $_POST['discord:webhook'];
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `app_maintenance` = '" . $app_maintenance . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `app_url` = '" . $app_url . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `enable_registration` = '" . $app_registration . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `enable_rechapa2` = '" . $app_recaptcha . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `rechapa2_site_key` = '" . $app_recaptcha_site_key . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `rechapa2_site_secret` = '" . $app_recaptcha_secret_key . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `discord` = '" . $app_discord_invite . "' WHERE `mythicalpics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `mythicalpics_settings` SET `discord_webhook` = '" . $app_discord_webhook . "' WHERE `mythicalpics_settings`.`id` = 1;");
    header('location: /oldadmin/settings/advanced');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?= $_ENV['app_name'] ?> - Settings
    </title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $_ENV['app_logo'] ?>">
    <link rel="icon" type="image/png" href="<?= $_ENV['app_logo'] ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= $_ENV['app_logo'] ?>" sizes="16x16">
    <link rel="shortcut icon" href="<?= $_ENV['app_logo'] ?>">
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
                    <?= $_ENV['app_name'] ?>
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
                <h1>Advanced Settings<small>Configure advanced settings for AtoroPics.</small></h1>
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
                                <li><a href="/oldadmin/settings">General</a></li>
                                <li><a href="/oldadmin/settings/mail">Mail</a></li>
                                <li class="active"><a href="/oldadmin/settings/advanced">Advanced</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <form action="" method="POST">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">App Core</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label class="control-label">App Maintenance</label>
                                            <div>
                                                <?php
                                                if ($_ENV['app_maintenance'] == "false") {
                                                    ?>
                                                    <select class="form-control" name="atoropics:settings:maintenance">
                                                        <option value="false">Off</option>
                                                        <option value="true">On</option>
                                                    </select>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <select class="form-control" name="atoropics:settings:maintenance">
                                                        <option value="true">On</option>
                                                        <option value="false">Off</option>
                                                    </select>
                                                    <?php
                                                }

                                                ?>
                                                <p class="text-muted small">The protocol for the app!</p>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group col-md-5">
                                            <label class="control-label">App Domain</label>
                                            <div>
                                                <input type="text" required="" class="form-control"
                                                    name="atoropics:settings:url" value="<?= $_ENV['app_url'] ?>">
                                                <p class="text-muted small">The domain of the application!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">reCAPTCHA / Registration</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label class="control-label">Registration Status</label>
                                            <div>
                                                <?php
                                                if ($_ENV['enable_registration'] == "true") {
                                                    ?>
                                                    <select class="form-control" name="registration:enabled">
                                                        <option value="true">Enabled</option>
                                                        <option value="false">Disabled</option>
                                                    </select>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <select class="form-control" name="registration:enabled">
                                                        <option value="false">Disabled</option>
                                                        <option value="true">Enabled</option>
                                                    </select>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="control-label">reCAPTCHA Status</label>
                                            <div>
                                                <?php
                                                if ($_ENV['enable_rechapa2'] == "true") {
                                                    ?>
                                                    <select class="form-control" name="recaptcha:enabled">
                                                        <option value="true">Enabled</option>
                                                        <option value="false">Disabled</option>
                                                    </select>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <select class="form-control" name="recaptcha:enabled">
                                                        <option value="false">Disabled</option>
                                                        <option value="true">Enabled</option>
                                                    </select>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Site Key</label>
                                            <div>
                                                <input type="text" required="" class="form-control"
                                                    name="recaptcha:website_key"
                                                    value="<?= $_ENV['rechapa2_site_key'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Secret Key</label>
                                            <div>
                                                <input type="text" required="" class="form-control"
                                                    name="recaptcha:secret_key"
                                                    value="<?= $_ENV['rechapa2_site_secret'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Discord</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Discord Server Invite</label>
                                            <div>
                                                <input type="text" required="" class="form-control"
                                                    name="discord:server:invite" value="<?= $_ENV['discord'] ?>">
                                                <p class="text-muted small">The server invite so users will join your
                                                    discord.</p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Discord Webhook</label>
                                            <div>
                                                <input type="password" required="" class="form-control"
                                                    name="discord:webhook" value="<?= $_ENV['discord_webhook'] ?>">
                                                <p class="text-muted small">The webhook where we are going to send the
                                                    reports!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-primary">
                                <div class="box-footer">
                                    <button type="submit" name="saveadvsettings"
                                        class="btn btn-sm btn-primary pull-right">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <div class="pull-right small text-gray" style="margin-right:10px;margin-top:-7px;">
                <strong><i class="fa fa-fw fa-code-fork"></i></strong>
                <?= $_ENV['version'] ?><br />
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