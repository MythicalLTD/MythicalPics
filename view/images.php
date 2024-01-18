<?php
require('../class/session.php');

$userdb = $conn->query("SELECT * FROM mythicalpics_users WHERE email = '" . mysqli_real_escape_string($conn, $_SESSION["SESSION_EMAIL"]) . "'")->fetch_array();
require('../class/maintenance.php');
$usrname = $userdb['username'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Set the number of images to display per page
$perPage = 12;

// Calculate the offset
$offset = ($page - 1) * $perPage;

// Retrieve the images with the calculated offset and limit
$result = mysqli_query($conn, "SELECT * FROM mythicalpics_imgs WHERE owner_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "' ORDER BY id DESC LIMIT $offset, $perPage");
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
    <?= $_ENV['app_name'] ?> | Dashboard
  </title>
  <script defer data-api="/stats/api/event" data-domain="preview.tabler.io" src="/stats/js/script.js"></script>
  <meta name="msapplication-TileColor" content="" />
  <meta name="theme-color" content="" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="HandheldFriendly" content="True" />
  <meta name="MobileOptimized" content="320" />
  <link rel="icon" href="<?= $_ENV['app_logo'] ?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?= $_ENV['app_logo'] ?>" type="image/x-icon" />
  <!-- CSS files -->
  <link href="/dist/css/tabler.min.css" rel="stylesheet" />
  <link href="/dist/css/tabler-flags.min.css" rel="stylesheet" />
  <link href="/dist/css/tabler-payments.min.css" rel="stylesheet" />
  <link href="/dist/css/tabler-vendors.min.css" rel="stylesheet" />
  <link href="/dist/css/demo.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/dist/css/discordEmbed.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
    integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link href="./dist/css/preloader.css" rel="stylesheet" />
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
  <script src="./dist/js/demo-theme.min.js"></script>
  <div class="page">
    <!-- Navbar -->
    <header class="navbar navbar-expand-md navbar-light d-print-none">
      <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
          aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
          <a>
            <?= $_ENV['app_name'] ?>
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
    </header>

    <div class="page-wrapper">
      <!-- Page header -->
      <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Gallery
              </h2>
            </div>
            <!-- Page title actions -->
          </div>
        </div>
      </div>
      <!-- Page body -->
      <div class="page-body">

        <div class="container-xl">

          <div class="row row-cards">
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<div class="col-sm-6 col-lg-4">';
              echo '  <div class="card card-sm">';
              echo '   <a href="#" class="d-block"><img src="' . $row['storage_folder'] . '" class="card-img-top"></a>';
              echo '    <div class="card-body">';
              echo '     <div class="d-flex align-items-center">';
              echo '        <span class="avatar me-3 rounded" style="background-image: url(' . $userdb['avatar'] . ')"></span>';
              echo '       <div>';
              echo '         <div>' . $row["name"] . '</div>';
              echo '          <div class="text-muted">' . $row["size"] . '</div>';
              echo '        </div>';
              echo '      </div>';
              echo '    </div>';
              echo '      <div class="card-footer text-end">';
              echo '        <a target="_blank" href="https://' . $_ENV['app_url'] . '/api/delete?owner_key=' . $_SESSION["api_key"] . '&imgid=' . $row["name"] . '" class="btn btn-danger">Delete</a>';
              echo '        <a download href="' . $row["storage_folder"] . '" class="btn btn-primary">Download</a>';
              echo '        <a href="https://' . $_ENV['app_url'] . '/i?i=' . $row["name"] . '"  class="btn btn-warning">Link</a>';
              echo '      </div>';
              echo '  </div>';
              echo '</div>';
            }
            ?>
            <div id="searchresult"></div>

            <!-- Pagination links -->
            <div class="pagination">
              <?php if ($page > 1): ?>
                <a href="dashboard?page=<?php echo $page - 1; ?>" class="btn btn-primary">Previous</a>
              <?php endif; ?>

              <?php if (mysqli_num_rows($result) > 0): ?>
                <a href="dashboard?page=<?php echo $page + 1; ?>" class="btn btn-primary">Next</a>
              <?php endif; ?>
            </div>
            <!-- Rest of your HTML code -->
          </div>

        </div>
      </div>
    </div>
    <?php
    include('ui/footer.php');
    ?>
  </div>
  </div>
  <!-- Libs JS -->
  <!-- Tabler Core -->
  <script src="./dist/js/tabler.min.js" defer></script>
  <script src="./dist/js/demo.min.js" defer></script>
  <script src="./dist/js/preloader.js" defer></script>
</body>

</html>