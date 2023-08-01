<?php
include(__DIR__ . '/../requirements/page.php');

if (isset($_POST['update_adv_settings'])) {
    $app_proto = $_POST['atoropics:settings:proto'];
    $app_maintenance = $_POST['atoropics:settings:maintenance'];
    $app_url = $_POST['atoropics:settings:url'];
    $app_registration = $_POST['registration:enabled'];
    $app_recaptcha = $_POST['recaptcha:enabled'];
    $app_recaptcha_site_key = $_POST['recaptcha:website_key'];
    $app_recaptcha_secret_key = $_POST['recaptcha:secret_key'];
    $app_discord_invite = $_POST['discord:server:invite'];
    $app_discord_webhook = $_POST['discord:webhook'];
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `app_proto` = '" . $app_proto . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `app_maintenance` = '" . $app_maintenance . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `app_url` = '" . $app_url . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `enable_registration` = '" . $app_registration . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `enable_rechapa2` = '" . $app_recaptcha . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `rechapa2_site_key` = '" . $app_recaptcha_site_key . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `rechapa2_site_secret` = '" . $app_recaptcha_secret_key . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `discord` = '" . $app_discord_invite . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `discord_webhook` = '" . $app_discord_webhook . "' WHERE `atoropics_settings`.`id` = 1;");
    header('location: /admin/settings');
}

if (isset($_POST['update_settings'])) {
    $app_name = $_POST['app:name'];
    $app_logo = $_POST['app:logo'];
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `app_name` = '" . $app_name . "' WHERE `atoropics_settings`.`id` = 1;");
    mysqli_query($conn, "UPDATE `atoropics_settings` SET `app_logo` = '" . $app_logo . "' WHERE `atoropics_settings`.`id` = 1;");
    header('location: /admin/settings');
}
?>
<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-semi-dark"
    data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <?php include(__DIR__ . '/../requirements/head.php'); ?>
    <title>
        <?= $settings['app_name'] ?> | Settings
    </title>
    <link rel="stylesheet" href="/assets/vendor/css/pages/page-help-center.css" />
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include(__DIR__ . '/../components/sidebar.php') ?>
            <div class="layout-page">
                <?php include(__DIR__ . '/../components/navbar.php') ?>
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a
                                    href="/admin/settings">Settings</a> /</span> Main</h4>
                        <div class="card mb-4">
                            <h5 class="card-header">General</h5>
                            <hr class="my-0">
                            <div class="card-body">
                                <form action="/admin/settings" method="POST">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="app:name" class="form-label">Company Name</label>
                                            <input class="form-control" type="text" id="app:name" name="app:name"
                                                value="<?= $settings['app_name'] ?>" placeholder="MythicalSystems">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="app:logo" class="form-label">Company Logo</label>
                                            <input class="form-control" type="text" id="app:logo" name="app:logo"
                                                value="<?= $settings['app_logo'] ?>" autofocus="">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" name="update_settings"
                                            class="btn btn-primary me-2 waves-effect waves-light" value="true">Save
                                            changes</button>
                                        <a href="/admin" class="btn btn-label-secondary waves-effect">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <h5 class="card-header">Mail</h5>
                            <hr class="my-0">
                            <div class="card-body">
                                <form action="/admin/settings/mail" method="GET">
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
                                                <input required="" type="number" class="form-control" name="mail:port"
                                                    value="<?= $settings['smtp_port'] ?>">
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
                                    <div class="mt-2">
                                        <button type="submit" name="update_settings"
                                            class="btn btn-primary me-2 waves-effect waves-light" value="true">Save
                                            changes</button>
                                        <a href="/admin" class="btn btn-label-secondary waves-effect">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <h5 class="card-header">Advanced Settings</h5>
                            <hr class="my-0">
                            <div class="card-body">
                                <form action="/admin/settings" method="POST">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label class="control-label">App Maintenance</label>
                                            <div>
                                                <?php
                                                if ($settings['app_maintenance'] == "false") {
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
                                            <label class="control-label">App Protocol</label>
                                            <div>
                                                <?php
                                                if ($settings['app_proto'] == "https://") {
                                                    ?>
                                                    <select class="form-control" name="atoropics:settings:proto">
                                                        <option value="https://">HTTPS</option>
                                                        <option value="http://">HTTP</option>
                                                    </select>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <select class="form-control" name="atoropics:settings:proto">
                                                        <option value="http://">HTTP</option>
                                                        <option value="https://">HTTPS</option>
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
                                                    name="atoropics:settings:url" value="<?= $settings['app_url'] ?>">
                                                <p class="text-muted small">The domain of the application!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label class="control-label">Registration Status</label>
                                            <div>
                                                <?php
                                                if ($settings['enable_registration'] == "true") {
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
                                                if ($settings['enable_rechapa2'] == "true") {
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
                                                    value="<?= $settings['rechapa2_site_key'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label">Secret Key</label>
                                            <div>
                                                <input type="text" required="" class="form-control"
                                                    name="recaptcha:secret_key"
                                                    value="<?= $settings['rechapa2_site_secret'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Discord Server Invite</label>
                                            <div>
                                                <input type="text" required="" class="form-control"
                                                    name="discord:server:invite" value="<?= $settings['discord'] ?>">
                                                <p class="text-muted small">The server invite so users will join your
                                                    discord.</p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Discord Webhook</label>
                                            <div>
                                                <input type="password" required="" class="form-control"
                                                    name="discord:webhook" value="<?= $settings['discord_webhook'] ?>">
                                                <p class="text-muted small">The webhook where we are going to send the
                                                    reports!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" name="update_adv_settings"
                                            class="btn btn-primary me-2 waves-effect waves-light" value="true">Save
                                            changes</button>
                                        <a href="/admin" class="btn btn-label-secondary waves-effect">Cancel</a>
                                    </div>
                                </form>
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
    <script src="/assets/js/dashboards-ecommerce.js"></script>
</body>

</html>