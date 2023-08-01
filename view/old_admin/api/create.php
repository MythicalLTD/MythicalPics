<?php
require('../class/session.php');

$userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();

if ($userdb['admin'] == "false") {
    header('location: /');
}
if (isset($_POST['submit'])) {
    $keyname = $_POST['api:key:name'];
    $api_key = "mythicalpics_" . generateRandomString(45);
    mysqli_query($conn, "INSERT INTO `atoropics_apikeys` (`api_key`, `owner_api_key`, `name`) VALUES ('" . $api_key . "', '" . $_SESSION["api_key"] . "', '" . $keyname . "')");
    header('location: /oldadmin/api');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?= $settings['app_name'] ?> - API
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
        <?php require(__DIR__ . '../../ui/navBar.php'); ?>

        <div class="content-wrapper" style="min-height: 888px;">
            <section class="content-header">
                <h1>Application API<small>Create a new application API key.</small></h1>
                <ol class="breadcrumb">
                    <li><a href="/admin">Admin</a></li>
                    <li><a href="/oldadmin/api">Application API</a></li>
                    <li class="active">New Credentials</li>
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
                <div class="row text-center">
                    <form method="POST">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <center>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="control-label" for="memoField">Name <span
                                                    class="field-required"></span></label>
                                            <input id="memoField" type="text" name="api:key:name" class="form-control">
                                        </div>
                                        <button type="submit" name="submit"
                                            class="btn btn-success btn-sm pull-right">Create Credentials</button>
                                    </div>
                                </center>
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