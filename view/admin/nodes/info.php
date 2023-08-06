<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

include(__DIR__ . '/../requirements/page.php');

if (isset($_GET['id'])) {
    if (!$_GET['id'] == "") {
        $node_query = "SELECT * FROM mythicalpics_nodes WHERE id = ?";
        $stmt = mysqli_prepare($conn, $node_query);
        mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $nodedb = $conn->query("SELECT * FROM mythicalpics_nodes WHERE id = '" . mysqli_real_escape_string($conn, mysqli_real_escape_string($conn, $_GET["id"])) . "'")->fetch_array();
            $client = new Client();

            try {
                $response = $client->get($nodedb['host'] . '/admin/node/health', [
                    'query' => ['auth_key' => $nodedb['auth_key']],
                ]);

                $statusCode = $response->getStatusCode();
                $data = json_decode($response->getBody(), true);

                if ($statusCode === 200) {
                    if (json_last_error() === JSON_ERROR_NONE) {
                        if (isset($data['code']) && $data['code'] === 200) {
                            $data = json_decode($response->getBody(), true);

                        }
                    } else {
                        header('location: /admin/nodes?e=Failed to connect to the node: <code>Invalid JSON response</code>');
                        die();
                    }

                } else {
                    header('location: /admin/nodes?e=Failed to connect to the node: <code>Unexpected status code:' . $statusCode . '</code>');
                    die();
                }
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    $response = $e->getResponse();
                    $statusCode = $response->getStatusCode();

                    $data = json_decode($response->getBody(), true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        header('location: /admin/nodes?e=Failed to connect to the node: <code>' . $data['message'] . '</code>');
                        die();
                    } else {
                        header('location: /admin/nodes?e=Failed to connect to the node: <code>' . $response->getReasonPhrase() . '</code>');
                        die();
                    }
                } else {
                    header('location: /admin/nodes?e=Failed to connect to the node: <code>' . $e->getMessage() . '</code>');
                    die();
                }
            }
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
        <?= $settings['app_name'] ?> | Info
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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin / Nodes /</span> Info</h4>
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
                                    <h5 class="card-header">Node Info</h5>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <form action="/admin/nodes/info" method="GET">
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input class="form-control" type="text" id="name" name="name"
                                                        value="<?= $nodedb['name'] ?>" />
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="description" class="form-label">Description</label>
                                                    <input class="form-control" type="text" id="description"
                                                        name="description" value="<?= $nodedb['description'] ?>" />
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="host" class="form-label">Host</label>
                                                    <input class="form-control"
                                                        disabled="You can't edit this via the GUI please delete the node and add it again to edit the host"
                                                        type="text" id="host" name="host"
                                                        value="<?= $nodedb['host'] ?>" />
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="auth_key" class="form-label">Auth Key</label>
                                                    <input class="form-control" type="text" id="auth_key"
                                                        name="auth_key" value="<?= $nodedb['auth_key'] ?>" />
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <button type="submit" name="edit_node" value="true"
                                                    class="btn btn-primary me-sm-3 me-1">Edit node</button>
                                                <a href="/admin/nodes" class="btn btn-label-secondary">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card mb-4">
                                    <h5 class="card-header">OS Info</h5>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="daemon:os" class="form-label">OS</label>
                                                <input class="form-control" disabled="" type="text" id="daemon:os"
                                                    name="daemon:os" value="<?= $data['os']['name'] ?>" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="daemon:uptime" class="form-label">Uptime</label>
                                                <input class="form-control" disabled="" type="text" id="daemon:uptime"
                                                    name="daemon:uptime" value="<?= $data['os']['uptime'] ?>" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-4">
                                    <h5 class="card-header">Daemon info</h5>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="daemon:version" class="form-label">Version</label>
                                                <input class="form-control" disabled="" type="text" id="daemon:version"
                                                    name="daemon:version" value="<?= $data['daemon']['version'] ?>" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="daemon:debug" class="form-label">Debug</label>
                                                <input class="form-control" disabled="" type="text" id="daemon:debug"
                                                    name="daemon:debug" value="<?php if ($data['daemon']['debug'] == "") {
                                                        echo 'false';
                                                    } else {
                                                        echo $data['daemon']['debug'];
                                                    } ?>" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-4">
                                    <h5 class="card-header">Hardware Info</h5>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="daemon:cpu" class="form-label">CPU</label>
                                                <input class="form-control" disabled="" type="text" id="daemon:cpu"
                                                    name="daemon:cpu" value="<?= $data['hardware']['cpu'] ?>" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="daemon:ram" class="form-label">Memory</label>
                                                <input class="form-control" disabled="" type="text" id="daemon:ram"
                                                    name="daemon:ram" value="<?php echo $data['hardware']['memory']['memory_free'].'MB / '.$data['hardware']['memory']['memory_total'].'MB'; ?>" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="daemon:ram" class="form-label">Disk</label>
                                                <input class="form-control" disabled="" type="text" id="daemon:ram"
                                                    name="daemon:ram" value="<?php echo $data['hardware']['disk']['disk_free'].'MB / '.$data['hardware']['disk']['disk_total'].'MB'; ?>" />
                                            </div>
                                        </div>
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