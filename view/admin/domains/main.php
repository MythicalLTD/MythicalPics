<?php
include(__DIR__ . '/../requirements/page.php');
$domainsPerPage = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $domainsPerPage;

$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = '';
if (!empty($searchKeyword)) {
    $searchCondition = " WHERE `domain` LIKE '%$searchKeyword%' OR `ownerkey` LIKE '%$searchKeyword%'";
}
$domain_query = "SELECT * FROM atoropics_domains" . $searchCondition . " ORDER BY `id` LIMIT $offset, $domainsPerPage";
$result = $conn->query($domain_query);
$totalDomainQuery = "SELECT COUNT(*) AS total_users FROM atoropics_domains" . $searchCondition;
$totalResult = $conn->query($totalDomainQuery);
$totalDomains = $totalResult->fetch_assoc()['total_users'];
$totalPages = ceil($totalDomains / $domainsPerPage);
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-semi-dark"
  data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <?php include(__DIR__ . '/../requirements/head.php'); ?>
    <title>
        <?= $settings['app_name'] ?> | Domains
    </title>
    <style>
        .avatar-image {
            width: 30px; /* Adjust the size as needed */
            height: 30px; /* Adjust the size as needed */
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include(__DIR__ . '/../components/sidebar.php') ?>
            <div class="layout-page">
                <?php include(__DIR__ . '/../components/navbar.php') ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
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
                        <!-- Search Form -->
                        <form class="mt-4">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search users..." name="search"
                                    value="<?= $searchKeyword ?>">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </form>
                        <div class="card">
                            <h5 class="card-header">
                                Domains
                                <a href="/admin/domains/new" class="btn btn-primary float-end">Add new domain</a>
                            </h5>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Domain</th>
                                            <th>Description</th>
                                            <th>Owner</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row['id'] . "</td>";
                                                echo "<td>" . $row['domain'] . "</td>";
                                                echo "<td>" . $row['description'] . "</td>";
                                                $check_query = "SELECT * FROM atoropics_users WHERE api_key = '" . $row['ownerkey'] . "'";
                                                $resulta = mysqli_query($conn, $check_query);
                                                if (mysqli_num_rows($resulta) > 0) {
                                                    $userdbinfoa = $resulta->fetch_assoc();
                                                    echo '<td><a href="/admin/users/edit?id=' . $userdbinfoa['id'] . '">' . $userdbinfoa['username'] . '<a></td>';
                                                } else {
                                                    echo '<td>None</td>';
                                                }
                                                echo "<td>" . $row['created-date'] . "</td>";
                                                echo "<td><a href=\"/admin/domains/edit?id=" . $row['id'] . "\" class=\"btn btn-primary\">Edit</a>&nbsp;<a href=\"/admin/domains/delete?id=" . $row['id'] . "\" class=\"btn btn-danger\">Delete</a></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>No domains found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mt-4">
                                <?php
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '&search=' . $searchKeyword . '">' . $i . '</a></li>';
                                }
                                ?>
                            </ul>
                        </nav>
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
    <script src="/assets/js/app-user-list.js"></script>
</body>

</html>