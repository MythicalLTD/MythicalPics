<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
require('../class/session.php');
$userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();
require('../class/maintenance.php');
$usrname = $userdb['username'];
$username = $userdb['username'];
if (isset($_GET['del_domain'])) {
  $domain_id = $_GET['del_domain'];
  $domainname = $_GET['domainname'];
  $query = "SELECT * FROM `atoropics_domains` WHERE `ownerkey`='".$_SESSION['api_key']."' AND `id`='".$domain_id."' AND `domain`='".$domainname."';";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) > 0) {
      mysqli_query($conn,"DELETE FROM atoropics_domains WHERE `atoropics_domains`.`id` = '$domain_id'");
      $disableCommand = 'sudo a2dissite '.$domainname.'.conf';
      ssh2_exec($connection, $disableCommand);
      ssh2_disconnect($connection);
      header('location: /domains');
      exit;
  } else {
      echo "<script>alert('Hey that's not nice of you this is not your domain');</script>";
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
  <link href="./dist/css/preloader.css" rel="stylesheet"/>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    <?php 
    if (isset($_GET['msg'])) {
      ?>
      <script>
      alert("Thanks for adding your domain please wait 5m to take effect!\nThen redownload your config from embed config");
      </script>
      <?php
    }    
    ?>
    <div class="page-wrapper">
      <!-- Page body -->
      <div class="page-body">
        <div class="container-xl d-flex flex-column justify-content-center">
          <div class="row row-cards">
            <div class="col-12">
              <div class="card">
                <div class="table-responsive">
                  <?php 
                    $query = "SELECT * FROM atoropics_domains WHERE ownerkey = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'";
                    $result = mysqli_query($conn, $query);              
                    if (mysqli_num_rows($result) > 0) {
                      echo '<table class="table table-vcenter card-table table-striped">
                              <thead>
                                <tr>
                                  <th>Domain Name</th>
                                  <th>Description</th>
                                  <th>Creation Date</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>';
                  
                              while ($row = mysqli_fetch_assoc($result)) {
                                echo '</td>
                                        <td><code>' . $row['domain'] . '</code></td>
                                        <td>' . $row['description'] . '</td>
                                        <td>' . $row['created-date'] . '</td>
                                        <td>
                                            <a href="?del_domain='.$row['id'].'&domainname='.$row['domain'].'" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                      </tr>';
                            }
                            
                  
                      echo '</tbody>
                            </table>';
                  } else {
                    echo '<table class="table table-vcenter card-table table-striped">
                    <tbody>
                      <tr>
                        <td colspan="6" style="text-align: center;">
                          <p style=" margin-bottom: 10px;">No domain found.</p>
                          <p style="margin-bottom: 10px;">Let`s fix that and add your domain.</p>
                          <p style="margin-bottom: 10px;">To add a domain you need to make sure that the domain / subdomain points to <code>'.$settings['app_url'].'</code>. This must be a CNAME and with CloudFlare proxy off.</p>
                          <br>
                          <br>
                          <a style="margin-bottom: 10px;"href="/domain/add" class="btn btn-primary" style="margin-bottom: 20px;">Add domain</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>';
                  }                  
                  ?>
                </div>
              </div>
            </div>
          </div>
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