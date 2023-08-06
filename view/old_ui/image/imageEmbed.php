<?php


if (isset($_GET['i'])) {
  $json_file = 'storage/json/' . $_GET['i'] . '.json';
  if (file_exists($json_file)) {
    $json_data = file_get_contents($json_file);
    $data = json_decode($json_data, true);
    if (!is_null($data)) {
      ?>
      <html lang="en">

      <head>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"> </script>
        <link rel="stylesheet" href="assets/css/style.css">
        <meta name="robots" content="noindex">
        <link rel="stylesheet" href="./dist/css/argon.css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.3/css/all.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="icon" type="image/png" href="<?= $settings['app_logo'] ?>">
        <title>
          <?= $settings['app_name'] ?> |
          <?= $data['title'] ?>
        </title>
        <meta property="twitter:card" content="summary_large_image" />
        <meta property="twitter:image" content="<?= $data['url'] ?>" />
        <meta property="og:image" content="<?= $data['url'] ?>" />
        <meta name="twitter:site" content="<?= $data['title'] ?>">
        <meta property="og:site_name" content="<?= $data['small_title'] ?>">
        <meta name="twitter:description" content="<?= $data['description'] ?>">
        <meta property="og:description" content="<?= $data['description'] ?>" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:image" content="<?= $data['url'] ?>" />
        <meta name="twitter:image:src" content="<?= $data['url'] ?>" />
        <meta property="og:image" content="<?= $data['url'] ?>" />
        <meta name="theme-color" content="<?= $data['theme'] ?>" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
          integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link type="application/json+oembed"
          href="<?php echo $settings['app_proto'] . $settings['app_url'] . '/' . $json_file; ?>" />
        <link href="./dist/css/preloader.css" rel="stylesheet" />
      </head>

      <body class="" style="background-color: #1a2234;">
        <div id="preloader">
          <div id="loader"></div>
        </div>
        <br><br>

        <div class="row mt-4 no-gutters">
          <div class="col-md-3"></div>
          <div class="col-md-6 mx-2">
            <div class="card card-stats text-center card-shadow bg-darker mb-4">
              <div class="card-body">
                <h3 class="card-title mb-0">
                  <?= $data['title'] ?>
                </h3>

                <h5 class="card-title mb-4">
                  <?= $data['description'] ?>
                </h5>


                <a href="<?= $data['url'] ?>" target="_blank">
                  <img src="<?= $data['url'] ?>" alt="image"
                    style="max-height: 75vh; width: auto; max-width: 100%; border-radius: 0.25rem" />
                </a>

                <h5 class="mt-4 mb-0">
                  Uploaded By: <code><?= $data['username'] ?></code>
                  </a>
                </h5>
                <h6 class="mb-3">
                  Uploaded At: <span class="text-white-50">
                    <?= $data['date'] ?>
                  </span>
                  <br>
                  Upload size: <span class="text-white-50">
                    <?= $data['filesize'] ?>
                  </span>
                </h6>

                <!--<button class="btn btn-danger" data-toggle="modal" id="report" data-target="#reportModal">
                  <span class="btn-inner--icon">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                  </span>
                  Report
                </button>-->
                <button onclick="copyImage()" class="btn btn-info" data-toggle="modal" data-target="#reportModal">
                  <span class="btn-inner--icon">
                    <i class="fa fa-clipboard mr-2"></i>
                  </span>
                  Copy
                </button>

                <a href="<?= mysqli_real_escape_string($conn, $data['url']) ?>" download target="_blank" class="btn btn-success">
                  <span class="btn-inner--icon">
                    <i class="fas fa-cloud-download mr-2"></i>
                  </span>
                  Download
                </a>
              </div>
            </div>
          </div>
        </div>
      </body>
      <script>
        function copyImage() {
          fetch("<?= $data['url'] ?>")
            .then(response => response.blob())
            .then(blob => {
              const item = new ClipboardItem({ "image/png": blob });
              navigator.clipboard.write([item]);
            });
        }
      </script>
      <script src="./dist/js/preloader.js" defer></script>

      </html>
    <?php
    } else {
      echo '<script>window.location.replace("' . $settings['app_proto'] . $settings['app_url'] . '");</script>';
      die();
    }
  } else {
    echo '<script>window.location.replace("' . $settings['app_proto'] . $settings['app_url'] . '");</script>';
    die();
  }
} else {
  echo '<script>window.location.replace("' . $settings['app_proto'] . $settings['app_url'] . '");</script>';
}
?>