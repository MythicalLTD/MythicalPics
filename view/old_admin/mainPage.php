<?php

require('../class/session.php');

$userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();
$version = file_get_contents("https://raw.githubusercontent.com/MythicalLTD/mythicalpics/main/version");
$settingsVersion = trim($settings['version']);
$githubVersion = trim($version);


$sql_users = "SELECT COUNT(*) AS total_count FROM atoropics_users";
$result_users = mysqli_query($conn, $sql_users);
$row_users = mysqli_fetch_assoc($result_users);

$sql_domains = "SELECT COUNT(*) AS total_count FROM atoropics_domains";
$result_domains = mysqli_query($conn, $sql_domains);
$row_domains = mysqli_fetch_assoc($result_domains);

$sql_imgs = "SELECT COUNT(*) AS total_count FROM atoropics_imgs";
$result_imgs = mysqli_query($conn, $sql_imgs);
$row_imgs = mysqli_fetch_assoc($result_imgs);

$sql_nodes = "SELECT COUNT(*) AS total_count FROM atoropics_nodes";
$result_nodes = mysqli_query($conn, $sql_nodes);
$row_nodes = mysqli_fetch_assoc($result_nodes);

if ($userdb['admin'] == "false") {
    header('location: /');
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?= $settings['app_name'] ?> - Administration
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
                            <a href="/oldadmin">
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
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Administrative Overview<small>A quick glance at your system.</small></h1>
                <ol class="breadcrumb">
                    <li><a href="/oldadmin">Admin</a></li>
                    <li class="active">Index</li>
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
                        <?php
                        if ($settingsVersion === $githubVersion) {
                            ?>
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">System Information</h3>
                                </div>
                                <div class="box-body">
                                    You are running MythicalPics version <code><?= $settings['version'] ?></code>. Your
                                    system
                                    is up-to-date!
                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">System Information</h3>
                                </div>
                                <div class="box-body">
                                    You are not up-to-date please update your MythicalPics panel, your version is:
                                    <code><?= $settings['version'] ?></code>.
                                </div>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-3 text-center">
                        <a href="https://discord.gg/7BZTmSK2D8"><button class="btn btn-warning" style="width:100%;"><i
                                    class="fa fa-fw fa-support"></i> Get Help <small>(via Discord)</small></button></a>
                    </div>
                    <div class="col-xs-6 col-sm-3 text-center">
                        <a href="https://github.com/mythicalltd/mythicalpics/blob/main/docs/introduction"><button
                                class="btn btn-primary" style="width:100%;"><i class="fa fa-fw fa-link"></i>
                                Documentation</button></a>
                    </div>
                    <div class="clearfix visible-xs-block">&nbsp;</div>
                    <div class="col-xs-6 col-sm-3 text-center">
                        <a href="https://github.com/mythicalltd/mythicalpics"><button class="btn btn-primary"
                                style="width:100%;"><i class="fa fa-fw fa-support"></i> Github</button></a>
                    </div>
                    <div class="col-xs-6 col-sm-3 text-center">
                        <a href="https://paypal.me/mythicalsystems"><button class="btn btn-success"
                                style="width:100%;"><i class="fa fa-fw fa-money"></i> Support
                                the Project</button></a>
                    </div>
                </div>
            </section>
            <div class="container">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <center>
                            <h3 class="box-title text-center">Total Users</h3>
                        </center>
                    </div>
                    <div class="box-body text-center">
                        <h3>
                            <?= $row_users['total_count'] ?>
                        </h3>
                    </div>
                </div>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <center>
                            <h3 class="box-title text-center">Total Domains</h3>
                        </center>
                    </div>
                    <div class="box-body text-center">
                        <h3>
                            <?= $row_domains['total_count'] ?>
                        </h3>
                    </div>
                </div>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <center>
                            <h3 class="box-title text-center">Total Images</h3>
                        </center>
                    </div>
                    <div class="box-body text-center">
                        <h3>
                            <?= $row_imgs['total_count'] ?>
                        </h3>
                    </div>
                </div>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <center>
                            <h3 class="box-title text-center">Total Nodes</h3>
                        </center>
                    </div>
                    <div class="box-body text-center">
                        <h3>
                            <?= $row_nodes['total_count'] ?> (SOON)
                        </h3>
                    </div>
                </div>

            </div>
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