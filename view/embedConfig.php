<?php

require('../class/session.php');
$userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_COOKIE["api_key"]) . "'")->fetch_array();
require('../class/maintenance.php');
$usrname = $userdb['username'];
$username = $userdb['username'];
$desc = $userdb['embed_desc'];
$desc_title = $userdb['embed_title'];
$small_title = $userdb['embed_small_title'];
$embed_theme = $userdb['embed_theme'];
$embed_desc = $userdb['embed_desc'];

$result = mysqli_query($conn, "SELECT * FROM atoropics_imgs");

include(__DIR__ . '/csrf.php');
$csrf = new CSRF();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($csrf->validate('configembed-form')) {
    if (isset($_POST['submit'])) {
      $title = $_POST['title'];
      $desc = $_POST['desc'];
      $small_title = $_POST['embed_small_title'];
      $colour = $_POST['colour'];
      mysqli_query($conn, 'UPDATE atoropics_users SET embed_title="' . $title . '" WHERE api_key="' . mysqli_real_escape_string($conn, $_COOKIE["api_key"]) . '"');
      mysqli_query($conn, 'UPDATE atoropics_users SET embed_desc="' . $desc . '" WHERE api_key="' . mysqli_real_escape_string($conn, $_COOKIE["api_key"]) . '"');
      mysqli_query($conn, 'UPDATE atoropics_users SET embed_small_title="' . $small_title . '" WHERE api_key="' . mysqli_real_escape_string($conn, $_COOKIE["api_key"]) . '"');
      mysqli_query($conn, 'UPDATE atoropics_users SET embed_theme="' . $colour . '" WHERE api_key="' . mysqli_real_escape_string($conn, $_COOKIE["api_key"]) . '"');
      header('location: /config');
    }
  } else {
    die('CSRF Login faild please click <a href="/config">here</a>');
  }
}

$query = "SELECT * FROM `atoropics_domains` WHERE `ownerkey` = '" . $_COOKIE['api_key'] . "'";
$result = mysqli_query($conn, $query);

$options = '';
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $domain = $row['domain'];
    $options .= "<option value='$domain'>$domain</option>";
  }
} else {
  $options = "<option disabled>No domains found</option>";
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
    <?= $settings['app_name'] ?> | Embed
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
    <div class="page-wrapper">
      <!-- Page body -->
      <div class="page-body">
        <div class="container-xl d-flex flex-column justify-content-center">
          <div class="row row-cards">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">User Config</h3>
                </div>
                <div class="card-body">
                  <form id="embedForm" action="" method="post">
                    <div class="mb-3">
                      <div class="row">
                        <div class="col-xl-8">
                          <div class="row">
                            <div class="mb-3">
                              <label class="form-label">Small Title</label>
                              <input type="text" class="form-control" name="embed_small_title" placeholder="Test"
                                name="embed_small_title" value="<?= $small_title ?>" required>
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Image Title</label>
                              <input type="text" class="form-control" name="title" placeholder="AtoroShare" name="title"
                                value="<?= $desc_title ?>" required>
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Image Description</label>
                              <textarea type="text" class="form-control" name="desc" rows="4" name="desc"
                                placeholder="My cool image hosting site..." required><?= $embed_desc ?></textarea>
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Domain</label>
                              <select class="form-select">
                                <?php echo $options; ?>
                              </select>
                            </div>
                            <label class="form-label">Image Embed Colour</label>
                            <div class="input-group mt-2">
                              <input type="text" class="form-control"
                                style="background-color: #26334c; text-align: center;" id="embedColour-text"
                                name="embedColour" readonly>
                              <div class="input-group-append">
                                <span class="input-group-text" id="embedColour-wrapper">
                                  <input type="color" id="embedColour" name="colour" value="<?php echo $embed_theme ?>"
                                    style="opacity: 0%;">
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="card-footer text-end">
                      <a href="/api/config" class="btn btn-secondary">Download Config</a>
                      <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <?= $csrf->input('configembed-form'); ?>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Embed Config</h3>
                </div>
                <div class="card-body">
                  <form id="embedForm" method="POST">
                    <div id="embedViewer-wrapper">
                      <div class="card" id="embedViewer" style="width: 100%!important; height: 400px;">
                        <div class="card-body pt-0" id="embedViewer_body">
                          <h5 class="mb-0 mt-0" readonly>
                            <?php echo $small_title ?>
                            <h5>
                              <input type="text" class="card-title embedViewer-input mb-0 mt-2" name="embedViewer_title"
                                id="embedViewer_title" placeholder="<?php echo $desc_title ?>" readonly>
                              <textarea class="embedViewer-input mb-0" name="embedViewer_description"
                                id="embedViewer_description" placeholder="Embed description..."
                                readonly><?php echo $embed_desc ?></textarea>
                              <div style="text-align: left; margin-top: 15px;"><img class="img-fluid"
                                  id="embedViewer_image"
                                  src="https://cdn.discordapp.com/attachments/1037824534880993310/1106309882677825696/New.png"
                                  style="height: 640; width: 1280; border-radius: 10px;">
                               </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
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
  <script type="text/javascript">

    function updateEmbedColour() {
      var colourPicker = document.getElementById("embedColour");
      var colourValue = document.getElementById("embedColour-text");
      var colourWrapper = document.getElementById("embedColour-wrapper");

      colourValue.value = colourPicker.value;
      $('#embedViewer').css('border-left', "4px solid " + colourPicker.value);
      $('#embedColour-wrapper').css('background', colourValue.value);
      setTimeout(updateEmbedColour, 1);
    }
    updateEmbedColour();
  </script>
  <!-- Libs JS -->
  <!-- Tabler Core -->
  <script src="/dist/js/tabler.min.js" defer></script>
  <script src="./dist/js/preloader.js" defer></script>
  <script src="/dist/js/demo.min.js" defer></script>
</body>

</html>