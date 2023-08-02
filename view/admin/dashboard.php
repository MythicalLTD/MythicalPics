<?php
include('requirements/page.php');

$sql_users = "SELECT COUNT(*) AS total_count FROM atoropics_users";
$result_users = mysqli_query($conn, $sql_users);
$row_users = mysqli_fetch_assoc($result_users);

$sql_domains = "SELECT COUNT(*) AS total_count FROM atoropics_domains";
$result_domains = mysqli_query($conn, $sql_domains);
$row_domains = mysqli_fetch_assoc($result_domains);

$sql_imgs = "SELECT COUNT(*) AS total_count FROM atoropics_imgs";
$result_imgs = mysqli_query($conn, $sql_imgs);
$row_imgs = mysqli_fetch_assoc($result_imgs);

//$sql_nodes = "SELECT COUNT(*) AS total_count FROM atoropics_nodes";
//$result_nodes = mysqli_query($conn, $sql_nodes);
//$row_nodes = mysqli_fetch_assoc($result_nodes);

?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-semi-dark"
    data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <?php include('requirements/head.php'); ?>
    <title>
        <?= $settings['app_name'] ?> | Dashboard
    </title>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include('components/sidebar.php') ?>
            <div class="layout-page">
                <?php include('components/navbar.php') ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <!-- Statistics -->
                            <div class="card h-100">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="card-title mb-0">Statistics</h5>
                                        <small id="updateText" class="text-muted">Updated 0 seconds ago</small>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row gy-3">
                                        <div class="col-md-3 col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-users" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                                                    </svg>
                                                </div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">
                                                        <?= $row_users['total_count'] ?>
                                                    </h5>
                                                    <small>Users</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-info me-3 p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-cloud-filled" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M10.04 4.305c2.195 -.667 4.615 -.224 6.36 1.176c1.386 1.108 2.188 2.686 2.252 4.34l.003 .212l.091 .003c2.3 .107 4.143 1.961 4.25 4.27l.004 .211c0 2.407 -1.885 4.372 -4.255 4.482l-.21 .005h-11.878l-.222 -.008c-2.94 -.11 -5.317 -2.399 -5.43 -5.263l-.005 -.216c0 -2.747 2.08 -5.01 4.784 -5.417l.114 -.016l.07 -.181c.663 -1.62 2.056 -2.906 3.829 -3.518l.244 -.08z"
                                                            stroke-width="0" fill="currentColor"></path>
                                                    </svg>
                                                </div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">
                                                        <?= $row_domains['total_count'] ?>
                                                    </h5>
                                                    <small>Total Domains</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-photo" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M15 8h.01"></path>
                                                        <path
                                                            d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z">
                                                        </path>
                                                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path>
                                                        <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path>
                                                    </svg>
                                                </div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">
                                                        <?= $row_imgs['total_count'] ?>
                                                    </h5>
                                                    <small>Images</small>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-3 col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-server" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path
                                                            d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z">
                                                        </path>
                                                        <path
                                                            d="M3 12m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v2a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z">
                                                        </path>
                                                        <path d="M7 8l0 .01"></path>
                                                        <path d="M7 16l0 .01"></path>
                                                    </svg>
                                                </div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">
                                                        $row_nodes['total_count']  (SOON)
                                                    </h5>
                                                    <small>Total Nodes</small>
                                                </div>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include('components/footer.php') ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    <?php include('requirements/footer.php') ?>
    <script src="/assets/js/dashboards-ecommerce.js"></script>

    <script>
        function updateElapsedTime() {
            const updateTextElement = document.getElementById('updateText');
            const startDate = new Date();

            function updateText() {
                const now = new Date();
                const timeDiff = now - startDate;
                let elapsed = '';

                if (timeDiff >= 1000 * 60 * 60 * 24 * 30) {
                    const months = Math.floor(timeDiff / (1000 * 60 * 60 * 24 * 30));
                    elapsed = months === 1 ? 'month' : 'months';
                    updateTextElement.textContent = `Updated ${months} ${elapsed} ago`;
                } else if (timeDiff >= 1000 * 60 * 60 * 24) {
                    const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                    elapsed = days === 1 ? 'day' : 'days';
                    updateTextElement.textContent = `Updated ${days} ${elapsed} ago`;
                } else if (timeDiff >= 1000 * 60 * 60) {
                    const hours = Math.floor(timeDiff / (1000 * 60 * 60));
                    elapsed = hours === 1 ? 'hour' : 'hours';
                    updateTextElement.textContent = `Updated ${hours} ${elapsed} ago`;
                } else if (timeDiff >= 1000 * 60) {
                    const minutes = Math.floor(timeDiff / (1000 * 60));
                    elapsed = minutes === 1 ? 'minute' : 'minutes';
                    updateTextElement.textContent = `Updated ${minutes} ${elapsed} ago`;
                } else {
                    const seconds = Math.floor(timeDiff / 1000);
                    elapsed = seconds === 1 ? 'second' : 'seconds';
                    updateTextElement.textContent = `Updated ${seconds} ${elapsed} ago`;
                }
            }

            setInterval(updateText, 1000);
        }
        window.onload = updateElapsedTime; 
    </script>
</body>

</html>