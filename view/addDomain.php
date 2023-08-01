<?php
require('../class/session.php');
$userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();
require('../class/maintenance.php');
$usrname = $userdb['username'];
$username = $userdb['username'];

include(__DIR__ . '/csrf.php');
$csrf = new CSRF();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($csrf->validate('adddomain-form')) {
        if (isset($_POST['submit'])) {
            $domain_name = $_POST['domain'];
            $domain_description = $_POST['description'];
            $query = "SELECT * FROM `atoropics_domains` WHERE `ownerkey`='" . $_SESSION['api_key'] . "';";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                ?>
                <script>
                    alert("Please do not use more then 1 domain");
                </script>
                <?php
                exit('<center><h1>I\'m sorry but you can\'t have more than 1 domain</h1><br><a href="#" onClick="window.location.reload();">Retry</a><br><a href="/domains">Back</a></center>');
            } else {

            }

            if ($domain_description == "" || $domain_name == "") {
                echo '<script>alert("I\'m sorry, but it cannot be blank.");</script>';
            } else {
                $domain_ip = gethostbyname($domain_name);
                $ip = $_ENV['SSH_IP'];
                $encoded_domain = htmlspecialchars($domain_name, ENT_QUOTES, 'UTF-8');
                $encoded_ip = htmlspecialchars($ip, ENT_QUOTES, 'UTF-8');
                $siteConfig = '<VirtualHost *:80>
  ServerName ' . $domain_name . '

  RewriteEngine On
  RewriteCond %{HTTPS} !=on
  RewriteRule ^/?(.*) https://%{SERVER_NAME}/$1 [R,L] 
</VirtualHost>

<VirtualHost *:443>
  ServerName ' . $domain_name . '
  DocumentRoot "/var/www/AtoroPics/public"

  AllowEncodedSlashes On
  
  php_value upload_max_filesize 100M
  php_value post_max_size 100M

  <Directory "/var/www/AtoroPics/public">
    Require all granted
    AllowOverride all
  </Directory>

  SSLEngine on
  SSLCertificateFile /etc/letsencrypt/live/' . $domain_name . '/fullchain.pem
  SSLCertificateKeyFile /etc/letsencrypt/live/' . $domain_name . '/privkey.pem
</VirtualHost>';
                $configFileName = '/etc/apache2/sites-available/' . $domain_name . '.conf';

                if ($domain_ip === $ip) {
                    $checkCommand = 'sudo ls /etc/letsencrypt/live/' . $domain_name;
                    $checkStream = ssh2_exec($connection, $checkCommand);
                    stream_set_blocking($checkStream, true);
                    $checkOutput = stream_get_contents($checkStream);
                    if (strpos($checkOutput, 'cert.pem') !== false && strpos($checkOutput, 'privkey.pem') !== false && strpos($checkOutput, 'fullchain.pem') !== false && strpos($checkOutput, 'chain.pem') !== false) {
                        echo 'Certificate already exists. Skipping Certbot command.';
                        //UGH PASTE THE CODE AGAIN
                        $createCommand = 'echo "' . $siteConfig . '" | sudo tee ' . $configFileName;
                        ssh2_exec($connection, $createCommand);
                        $enableCommand = 'sudo a2ensite ' . $domain_name . '.conf';
                        ssh2_exec($connection, $enableCommand);

                        ssh2_disconnect($connection);
                        mysqli_query($conn, "INSERT INTO `atoropics_domains` (`domain`, `description`, `ownerkey`) VALUES ('$domain_name', '$domain_description', '" . $_SESSION["api_key"] . "');");
                        header('location: /domains?msg=done');
                    } else {
                        try {
                            $command = "sudo certbot certonly --apache --non-interactive --agree-tos --register-unsafely-without-email -d " . $domain_name;
                            ssh2_exec($connection, $command);
                            $createCommand = 'echo "' . $siteConfig . '" | sudo tee ' . $configFileName;
                            ssh2_exec($connection, $createCommand);
                            $enableCommand = 'sudo a2ensite ' . $domain_name . '.conf';
                            ssh2_exec($connection, $enableCommand);
                            ssh2_disconnect($connection);
                            mysqli_query($conn, "INSERT INTO `atoropics_domains` (`domain`, `description`, `ownerkey`, `enabled`) VALUES ('$domain_name', '$domain_description', '" . $_SESSION["api_key"] . "', 'true');");
                            header('location: /domains?msg=done');
                        } catch (Exception $e) {
                            echo 'An error occurred: ' . $e->getMessage();
                            echo 'Certbot command failed. Error output: ' . $output;
                            die('<center><h1>Certbot command failed. Error output:</h1><br><code>' . $output . '</code><br><a href="#" onClick="window.location.reload();">Retry</a><br><a href="/domains">Back</a></center>');
                        }
                    }
                } else {
                    die('<font color="red"><center><h1>The domain <code>' . $encoded_domain . '</code> does not point to our server. Please point your domain using a CNAME to <code>' . $settings['app_url'] . '</code> after that please refresh the page to continue adding the domain.</h1></font><h3>DO NOT USE CLOUDFLARE PROXY FOR THIS. IT WILL BREAK YOUR UPLOAD SCRIPT</h3><h4>This will take some time to update so please wait while you try again</h4><a href="#" onClick="window.location.reload();">Retry</a><br><a href="/domains">Back</a></center>');
                }
                return;
            }
        }
    }
    else {
        die('CSRF Login faild please refresh');
    }
}
?>

<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net <?php echo $usrname ?>
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
        <?= $settings['app_name'] ?> | Domains
    </title>
    <script defer data-api="/stats/api/event" data-domain="preview.tabler.io" src="/stats/js/script.js"></script>
    <meta name="msapplication-TileColor" content="" />
    <meta name="theme-color" content="" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <link rel="icon" href="<?= $settings['app_logo'] ?>" type="image/x-icon" />
    <link rel="shortcut icon" href="<?= $settings['app_logo'] ?>" type="image/x-icon" />
    <!-- CSS files -->
    <link href="/dist/css/tabler.min.css" rel="stylesheet" />
    <link href="/dist/css/tabler-flags.min.css" rel="stylesheet" />
    <link href="/dist/css/tabler-payments.min.css" rel="stylesheet" />
    <link href="/dist/css/tabler-vendors.min.css" rel="stylesheet" />
    <link href="/dist/css/demo.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/dist/css/discordEmbed.css">
    <link href="./dist/css/preloader.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div id="loader"></div>
    </div>
    <script src="/dist/js/demo-theme.min.js"></script>
    <div class="page">
        <!-- Navbar -->
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href=".">
                        <?= $settings['app_name'] ?>
                    </a>
                </h1>
                <?php
                include('ui/profileDropdown.php');
                ?>
            </div>
        </header>
        <?php
        include('ui/navBar.php');
        ?>
        <div class="page-body">
            <div class="container-xl d-flex justify-content-center align-items-center" style="min-height: 20vh;">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3 class="card-title text-center">Add Domain</h3>
                        </div>
                        <div class="card-body">
                            <form method="post">
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Domain</label>
                                        <input type="text" class="form-control" name="domain"
                                            placeholder="i.yourdomain.net" value="" required="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <input type="text" class="form-control" name="description"
                                            placeholder="My awsome domain" value="" required="">
                                    </div>
                                    <div class="input-group mt-2">
                                        <span></span>
                                    </div>
                                </div>
                        </div>
                        <br>
                        <?= $csrf->input('adddomain-form'); ?>
                        <div class="card-footer text-end text-center">
                            <button type="submit" name="submit" class="btn btn-primary">Create</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <div class="page-wrapper">
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl d-flex flex-column justify-content-center">

            </div>
            <?php
            include('ui/footer.php');
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="/dist/js/tabler.min.js" defer></script>
    <script src="/dist/js/demo.min.js" defer></script>
    <script src="./dist/js/preloader.js" defer></script>
</body>

</html>