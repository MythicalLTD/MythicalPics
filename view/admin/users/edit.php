<?php
include(__DIR__ . '/../requirements/page.php');

if (isset($_GET['edit_user'])) {
    if (!$_GET['id'] == "" || !$_GET['edit_user'] == "") {
        $user_query = "SELECT * FROM atoropics_users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $userdbdd = $conn->query("SELECT * FROM atoropics_users WHERE id = '" . mysqli_real_escape_string($conn, $_GET["id"]) . "'")->fetch_array();
            $email = mysqli_real_escape_string($conn, $_GET['email']);
            $username = mysqli_real_escape_string($conn, $_GET['username']);
            $avatar = mysqli_real_escape_string($conn, $_GET['avatar']);
            $admin = mysqli_real_escape_string($conn, $_GET['root_admin']);
            if ($admin == "1") {
                $conn->query("UPDATE `atoropics_users` SET `admin` = 'true' WHERE `atoropics_users`.`id` = " . mysqli_real_escape_string($conn, $_GET["id"]) . ";");
            } else if ($admin == "0") {
                $conn->query("UPDATE `atoropics_users` SET `admin` = 'false' WHERE `atoropics_users`.`id` = " . mysqli_real_escape_string($conn, $_GET["id"]) . ";");
            }
            if ($email !== "" && $email !== $userdbdd['email']) {
                $user_query = "SELECT * FROM atoropics_users WHERE email = ?";
                $stmt = mysqli_prepare($conn, $user_query);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    header('location: /admin/users?e=Email is already taken in the database&id='.$_GET['id']);
                    die();
                }
                $conn->query("UPDATE `atoropics_users` SET `email` = '" . $email . "' WHERE `atoropics_users`.`id` = " . mysqli_real_escape_string($conn, $_GET["id"]) . ";");
            }
            
            if ($username !== "" && $username !== $userdbdd['username']) {
                $user_query = "SELECT * FROM atoropics_users WHERE username = ?";
                $stmt = mysqli_prepare($conn, $user_query);
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    header('location: /admin/users?e=Username is already taken in the database&id='.$_GET['id']);
                    die();
                }
                $conn->query("UPDATE `atoropics_users` SET `username` = '" . $username . "' WHERE `atoropics_users`.`id` = " . mysqli_real_escape_string($conn, $_GET["id"]) . ";");
            }
            
            if (!$avatar == "") {
                $conn->query("UPDATE `atoropics_users` SET `avatar` = '" . $avatar . "' WHERE `atoropics_users`.`id` = " . mysqli_real_escape_string($conn, $_GET["id"]) . ";");
            } 
            header('location: /admin/users/edit?id=' . mysqli_real_escape_string($conn, $_GET["id"]));
            $conn->close();
            die();
        }
    } else {
        header('location: /admin/users');
        die();
    }
} else if (isset($_GET['reest_key'])) {
    if (!$_GET['id'] == "" && !$_GET['reest_key'] == "") {
        $user_query = "SELECT * FROM atoropics_users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
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
            $conn->query("UPDATE `atoropics_users` SET `api_key` = '".$key."' WHERE `atoropics_users`.`id` = ".mysqli_real_escape_string($conn,$_GET['id']).";");
            $conn->close();
            header('location: /admin/users/edit?id='.$_GET['id'].'&s=We updated the api key for the user!');
        } 
    } 
} else if (isset($_GET['reset_password'])) {
    if (!$_GET['id'] == "" && !$_GET['reset_password'] == "") {
        $user_query = "SELECT * FROM atoropics_users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $pwd = mysqli_real_escape_string($conn,$_GET['pwd']);
            $password = md5($pwd);
            $conn->query("UPDATE `atoropics_users` SET `password` = '".$password."' WHERE `atoropics_users`.`id` = ".mysqli_real_escape_string($conn,$_GET['id']).";");
            $conn->close();
            header('location: /admin/users/edit?id='.$_GET['id'].'&s=We updated the password for the user!');
        } 
    } 
} else if (isset($_GET['id'])) {
    if (!mysqli_real_escape_string($conn, $_GET["id"]) == "") {
        $user_query = "SELECT * FROM atoropics_users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $userdbdd = $conn->query("SELECT * FROM atoropics_users WHERE id = '" . mysqli_real_escape_string($conn, $_GET["id"]) . "'")->fetch_array();
        }
    } else {
        header('location: /admin/users');
        die();
    }
} else {
    header('location: /admin/users');
    die();
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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Users /</span> Edit</h4>
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
                        <?php
                        if (isset($_GET['s'])) {
                            ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <?= $_GET['s'] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-pills flex-column flex-md-row mb-4">
                                    <li class="nav-item">
                                        <a href="/admin/users/edit?id=<?= $_GET['id'] ?>" class="nav-link active"><i
                                                class="ti-xs ti ti-users me-1"></i> Account</a>
                                    </li>
                                    <!--<li class="nav-item">
                      <a class="nav-link" href="pages-account-settings-billing.html"
                        ><i class="ti-xs ti ti-file-description me-1"></i> Billing & Plans</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="pages-account-settings-notifications.html"
                        ><i class="ti-xs ti ti-bell me-1"></i> Notifications</a
                      >
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="pages-account-settings-connections.html"
                        ><i class="ti-xs ti ti-link me-1"></i> Connections</a
                      >
                    </li>-->
                                </ul>
                                <div class="card mb-4">
                                    <h5 class="card-header">Profile Details</h5>
                                    <!-- Account -->
                                    <div class="card-body">
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            <img src="<?= $userdbdd['avatar'] ?>" alt="user-avatar"
                                                class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                        </div>
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <form action="/admin/users/edit" method="GET">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input class="form-control" type="text" id="username"
                                                        name="username" value="<?= $userdbdd['username'] ?>"
                                                        placeholder="jhondoe" />
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="role" class="form-label">Role</label>
                                                    <select name="root_admin" class="form-control">
                                                        <?php if ($userdbdd['admin'] == "false") {
                                                            ?>
                                                            <option value="0" selected="&quot;selected&quot;">No</option>
                                                            <option value="1">Yes</option>
                                                            <?php
                                                        } else if ($userdbdd['admin'] == "true") {
                                                            ?>
                                                                <option value="0">No</option>
                                                                <option value="1" selected="&quot;selected&quot;">Yes</option>
                                                                <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                               
                                                <div class="mb-3 col-md-6">
                                                    <label for="email" class="form-label">E-mail</label>
                                                    <input class="form-control" type="email" id="email" name="email"
                                                        value="<?= $userdbdd['email'] ?>"
                                                        placeholder="john.doe@example.com" />
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="avatar" class="form-label">Avatar</label>
                                                    <input class="form-control" type="text" id="avatar" name="avatar"
                                                        value="<?= $userdbdd['avatar'] ?>" />
                                                </div>
                                                <input class="form-control" type="hidden" id="id" name="id"
                                                    value="<?= $_GET['id'] ?>">

                                            </div>
                                            <div class="mt-2">
                                                <button type="submit" name="edit_user" class="btn btn-primary me-2"
                                                    value="true">Save changes</button>
                                                <a href="/admin/users" class="btn btn-label-secondary">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <h5 class="card-header">Danger Zone</h5>
                                    <div class="card-body">
                                        <div class="mb-3 col-12 mb-0">
                                            <div class="alert alert-warning">
                                                <h5 class="alert-heading mb-1">Make sure you read what the button does!
                                                </h5>
                                                <p class="mb-0">Once you press a button, there is no going back. Please
                                                    be certain.</p>
                                            </div>
                                        </div>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#resetPwd"
                                            class="btn btn-danger deactivate-account">Reset Password</button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#resetKey"
                                            class="btn btn-danger deactivate-account">Reset API Key</button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteacc"
                                            class="btn btn-danger deactivate-account">Delete Account</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteacc" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                            <div class="modal-content p-3 p-md-5">
                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <h3 class="mb-2">Delete this user?</h3>
                                        <p class="text-muted">When you choose to delete this user, please be aware that
                                            all associated user data will be permanently wiped. This action is
                                            irreversible, so proceed with caution!
                                        </p>
                                    </div>
                                    <form method="GET" action="/admin/users/delete" class="row g-3">
                                        <div class="col-12 text-center">
                                            <button type="submit" name="id" value="<?= $_GET['id'] ?>"
                                                class="btn btn-danger me-sm-3 me-1">Delete user</button>
                                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                                aria-label="Close">Cancel </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="resetKey" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                            <div class="modal-content p-3 p-md-5">
                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <h3 class="mb-2">Reset user secret key?</h3>
                                        <p class="text-muted">After updating the key, the user will have to login again.
                                        </p>
                                    </div>
                                    <form method="GET" action="/admin/users/edit" class="row g-3">
                                        <div class="col-12 text-center">
                                            <input type="hidden" name="reest_key" value="true"> 
                                            <button type="submit" name="id" value="<?= $_GET['id'] ?>"
                                                class="btn btn-danger me-sm-3 me-1">Reset key</button>
                                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                                aria-label="Close">Cancel </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="resetPwd" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                            <div class="modal-content p-3 p-md-5">
                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <h3 class="mb-2">Reset user password?</h3>
                                        <p class="text-muted">After updating the key, the user will stay logged in!!</p>
                                    </div>
                                    <form method="GET" action="/admin/users/edit" class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label" for="resetPwd">New Password</label>
                                            <input type="password" id="pwd" name="pwd" class="form-control"
                                                placeholder="" required />
                                        </div>
                                        <div class="col-12 text-center">
                                            <input type="hidden" name="reset_password" value="true"> 
                                            <button type="submit" name="id" value="<?= $_GET['id'] ?>"
                                                class="btn btn-danger me-sm-3 me-1">Reset password</button>
                                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                                aria-label="Close">Cancel </button>
                                        </div>
                                    </form>
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
    <!-- Page JS -->
    <script src="/assets/js/pages-account-settings-account.js"></script>
</body>

</html>