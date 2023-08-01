<?php 
include(__DIR__ . '/../requirements/page.php');

if (isset($_GET['edit_domain']) && isset($_GET['id']) && !empty($_GET['edit_domain']) && !empty($_GET['id'])) {
    $domain_id = mysqli_real_escape_string($conn, $_GET['id']);
    $description = mysqli_real_escape_string($conn, $_GET['description']);
    $skey = mysqli_real_escape_string($conn, $_GET['skey']);
    $user_query = "SELECT * FROM atoropics_domains WHERE id = ?";
    $stmt = mysqli_prepare($conn, $user_query);
    mysqli_stmt_bind_param($stmt, "s", $domain_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $domaind = $result->fetch_array();

        if (!empty($skey) && $skey !== $domaind['ownerkey']) {
            $user_query = "SELECT * FROM atoropics_domains WHERE ownerkey = ?";
            $stmt = mysqli_prepare($conn, $user_query);
            mysqli_stmt_bind_param($stmt, "s", $skey);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                header('location: /admin/domains?e=User can\'t have more than 1 domain');
                exit();
            } else {
                $conn->query("UPDATE `atoropics_domains` SET `ownerkey` = '" . $skey . "' WHERE `id` = " . $domain_id . ";");
            }
        }

        if (!empty($description) && $description !== $domaind['description']) {
            $conn->query("UPDATE `atoropics_domains` SET `description` = '" . $description . "' WHERE `id` = " . $domain_id . ";");
        }

        header('location: /admin/domains/edit?id=' . $domain_id);
        exit();
    } else {
        header('location: /admin/domains');
        exit();
    }
} else if (isset($_GET['id'])) {
    if (!$_GET['id'] == "") {
        $domain_query = "SELECT * FROM atoropics_domains WHERE id = ?";
        $stmt = mysqli_prepare($conn, $domain_query);
        mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $domaindb = $conn->query("SELECT * FROM atoropics_domains WHERE id = '" . mysqli_real_escape_string($conn, $_GET["id"]) . "'")->fetch_array();
        }
    } else {
        header('location: /admin/domains');
        exit();
    }
} else {
    header('location: /admin/domains');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-semi-dark"
    data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <?php include(__DIR__ . '/../requirements/head.php'); ?>
    <title>
        <?= $settings['app_name'] ?> | Edit
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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Domains /</span> Edit</h4>
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
                                <div class="card mb-4">
                                    <h5 class="card-header">Domains Info</h5>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <form action="/admin/domains/edit" method="GET">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="domain" class="form-label">Domain</label>
                                                    <input class="form-control" disabled="" type="text" id="domain" name="domain" value="<?= $domaindb['domain'] ?>"/>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="description" class="form-label">Description</label>
                                                    <input class="form-control" type="text" name="description"
                                                value="<?= $domaindb['description'] ?>" />
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="skey" class="form-label">Owner User Key</label>
                                                    <input class="form-control" type="text" name="skey" value="<?= $domaindb['ownerkey'] ?>"/>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="created-date" class="form-label">Owner User Key</label>
                                                    <input class="form-control" type="text" disabled="" name="created-date" value="<?= $domaindb['created-date'] ?>"/>
                                                </div>
                                                <input name="id" value="<?= $_GET['id']?>" type="hidden">
                                            </div>
                                            <div class="mt-2">
                                                <button type="submit" name="edit_domain" class="btn btn-primary me-2"
                                                    value="true">Save changes</button>
                                                <a href="/admin/domains" class="btn btn-label-secondary">Cancel</a>
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
    <!-- Page JS -->
    <script src="/assets/js/pages-account-settings-account.js"></script>
</body>

</html>