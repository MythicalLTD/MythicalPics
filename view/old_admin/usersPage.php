<?php
require('../class/session.php');
$userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();

if ($userdb['admin'] == "false") {
    header('location: /');
}
$limit = 50;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = isset($_GET['filter']['email']) ? $_GET['filter']['email'] : '';
$searchQuery = '';
if (!empty($search)) {
    $searchQuery = "WHERE email LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}
$countResult = $conn->query("SELECT COUNT(*) as count FROM atoropics_users $searchQuery");
$totalUsers = $countResult->fetch_assoc()['count'];
$totalPages = ceil($totalUsers / $limit);
$query = "SELECT * FROM atoropics_users $searchQuery LIMIT $start, $limit";
$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?= $settings['app_name'] ?> - Users
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
                <h1>Users<small>All registered users on the system.</small></h1>
                <ol class="breadcrumb">
                    <li><a href="/admin">Admin</a></li>
                    <li class="active">Users</li>
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
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">User List</h3>
                                <div class="box-tools search01">
                                    <form action="/oldadmin/users" method="GET">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="filter[email]" class="form-control pull-right"
                                                value="<?= htmlspecialchars($search) ?>" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-default"><i
                                                        class="fa fa-search"></i></button>
                                                <a href="/oldadmin/users/new"><button type="button"
                                                        class="btn btn-sm btn-primary"
                                                        style="border-radius: 0 3px 3px 0;margin-left:-1px;">Create
                                                        New</button></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <!--<th class="text-center"><span data-toggle="tooltip" data-placement="top"
                                                    title="Imagines that the users own">Imagines Owned</span></th>-->
                                            <th class="text-center"><span data-toggle="tooltip" data-placement="top"
                                                    title="Domains that the user own.">Domains Owned</span></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                            <tr class="align-middle">
                                                <td><code><?= $user['id'] ?></code></td>
                                                <td><a href="/oldadmin/users/edit?id=<?= $user['id'] ?>">
                                                        <?= $user['email'] ?>
                                                    </a>
                                                    <?php if ($user['admin'] == "true") {
                                                        ?>
                                                        <i class="fa fa-star text-yellow"></i>
                                                        <?php
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?= $user['username'] ?>
                                                </td>
                                                <!--<td class="text-center">
                                                    <a href="#">
                                                        <?php
                                                        //$imaginesResult = $conn->query("SELECT COUNT(*) FROM atoropics_imgs WHERE owner_key = '" . $user['api_key'] . "'");
                                                        //$imaginesCount = $imaginesResult->fetch_row()[0];
                                                        //echo $imaginesCount;
                                                        ?>
                                                    </a>
                                                </td>-->
                                                <td class="text-center"><!--<a href="#">-->
                                                    <?php
                                                    $domainsResult = $conn->query("SELECT COUNT(*) FROM atoropics_domains WHERE ownerkey = '" . $user['api_key'] . "'");
                                                    $domainsCount = $domainsResult->fetch_row()[0];
                                                    echo $domainsCount;
                                                    ?></a>
                                                </td>
                                                <td class="text-center"><img src="<?= $user['avatar'] ?>"
                                                        style="height:20px;" class="img-circle">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-footer with-border">
                                <div class="col-md-12 text-center">
                                    <nav>
                                        <ul class="pagination">
                                            <?php if ($page > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="/oldadmin/users?page=<?= $page - 1 ?>&filter[email]=<?= urlencode($search) ?>"
                                                        aria-label="Previous">
                                                        <span aria-hidden="true">‹</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                    <a class="page-link"
                                                        href="/oldadmin/users?page=<?= $i ?>&filter[email]=<?= urlencode($search) ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <?php if ($page < $totalPages): ?>
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="/oldadmin/users?page=<?= $page + 1 ?>&filter[email]=<?= urlencode($search) ?>"
                                                        aria-label="Next">
                                                        <span aria-hidden="true">›</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>

                                </div>
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