<?php
if ($settings['enable_rechapa2'] == "true") {
  $recaptcha = new \ReCaptcha\ReCaptcha($settings['rechapa2_site_secret']);
}
if ($settings['enable_registration'] == "false") {
  header('location: login');
}
$lifetime = 30 * 24 * 60 * 60;
ini_set('session.gc_maxlifetime', $lifetime);
session_set_cookie_params($lifetime);
session_start();
include(__DIR__ . '/../csrf.php');
$csrf = new CSRF();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (isset($_SESSION['SESSION_EMAIL'])) {
  header("Location: /dashboard");
  die();
}
if ($settings['enable_smtp'] == "true") {
  $smtp_host = $settings['smtp_host'];
  $smtp_username = $settings['smtp_user'];
  $smtp_password = $settings['smtp_password'];
  $smtp_port = $settings['smtp_port'];
  $smtp_from = $settings['smtp_from'];
  $name = $settings['smtp_from_name'];
}
$length = 16;
$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$pass = array();
$alphaLength = strlen($alphabet) - 1;
for ($i = 0; $i < $length; $i++) {
  $n = rand(0, $alphaLength);
  $pass[] = $alphabet[$n];
}
$timestamp = time();
$formatted_timestamp = date("HisdmY", $timestamp);
$encoded_timestamp = base64_encode($formatted_timestamp);
$key = $encoded_timestamp . implode($pass);
$ip_addres = getclientip();
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($csrf->validate('register-form')) {
    if (isset($_POST['submit'])) {
      if ($settings['enable_rechapa2'] == "false") {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        if ($settings['enable_smtp'] == "true") {
          $code = mysqli_real_escape_string($conn, md5(rand()));
        } else {
          $code = "null";
        }

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM atoropics_users WHERE email='" . $email . "'")) > 0) {
          $msg = "<div class='alert alert-danger'>" . $email . " - This email address is in use.</div>";
        }
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM atoropics_users WHERE username='" . $name . "'")) > 0) {
          $msg = "<div class='alert alert-danger'>" . $name . " - This username is in use.</div>";
        } else {
          if ($password === $confirm_password) {
            $default = "https://www.gravatar.com/avatar/00000000000000000000000000000000";
            $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default);

            $sql = "INSERT INTO atoropics_users (username, avatar, email, password, code, last_ip, register_ip, api_key, admin, embed_title, embed_desc, embed_theme) VALUES ('" . $name . "', '{$grav_url}', '" . $email . "', '{$password}', '{$code}', '{$ip_addres}', '{$ip_addres}', '{$key}', 'false', 'AtoroShare', '#ffff' ,'A free image hosting service')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
              echo "<div style='display: none;'>";
              //Create an instance; passing `true` enables exceptions
              if ($settings['enable_smtp'] == "true") {
                $mail = new PHPMailer(true);

                try {
                  //Server settings
                  $mail->SMTPDebug = 2; //Enable verbose debug output
                  $mail->isSMTP(); //Send using SMTP
                  $mail->Host = $smtp_host; //Set the SMTP server to send through
                  $mail->SMTPAuth = true; //Enable SMTP authentication
                  $mail->Username = $smtp_username; //SMTP username
                  $mail->Password = $smtp_password; //SMTP password
                  $mail->SMTPSecure = 'tls'; //Enable implicit TLS encryption
                  $mail->Port = $smtp_port; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                  //Recipients
                  $mail->setFrom($smtp_from);
                  $mail->addAddress($email);

                  //Content
                  $mail->isHTML(true); //Set email format to HTML
                  $mail->Subject = 'no reply';
                  $mail->Body = 'Here is the verification link <b><a href="' . $settings["app_proto"] . $settings["app_url"] . '/auth/login/?verification=' . $code . '">' . $settings["app_proto"] . $settings["app_url"] . '/auth/login/?verification=' . $code . '</a></b>';

                  $mail->send();
                  echo 'Message has been sent';
                } catch (Exception $e) {
                  echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo . "";
                }
                echo "</div>";
                $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
              } else {
                echo "</div>";
                $msg = "<div class='alert alert-info'>Thanks for using " . $settings['app_name'] . "</div>";
                header('location: /auth/login');
              }

            } else {
              echo "</div>";
              $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
            }
          } else {
            echo "</div>";
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
          }
        }
      } else {
        $resp = $recaptcha->setExpectedHostname($_SERVER['HTTP_HOST'])
          ->verify($_POST["g-recaptcha-response"], $_SERVER['REMOTE_ADDR']);
        if ($resp->isSuccess()) {
          $name = mysqli_real_escape_string($conn, $_POST['name']);
          $email = mysqli_real_escape_string($conn, $_POST['email']);
          $password = mysqli_real_escape_string($conn, md5($_POST['password']));
          $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
          if ($settings['enable_smtp'] == "true") {
            $code = mysqli_real_escape_string($conn, md5(rand()));
          } else {
            $code = "null";
          }

          if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM atoropics_users WHERE email='" . $email . "'")) > 0) {
            $msg = "<div class='alert alert-danger'>" . $email . " - This email address is in use.</div>";
          }
          if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM atoropics_users WHERE username='" . $name . "'")) > 0) {
            $msg = "<div class='alert alert-danger'>" . $name . " - This username is in use.</div>";
          } else {
            if ($password === $confirm_password) {
              $default = "https://www.gravatar.com/avatar/00000000000000000000000000000000";
              $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default);

              $sql = "INSERT INTO atoropics_users (username, avatar, email, password, code, last_ip, register_ip, api_key, admin, embed_title, embed_desc, embed_theme) VALUES ('" . $name . "', '{$grav_url}', '" . $email . "', '{$password}', '{$code}', '{$ip_addres}', '{$ip_addres}', '{$key}', 'false', 'AtoroShare', '#ffff' ,'A free image hosting service')";
              $result = mysqli_query($conn, $sql);

              if ($result) {
                echo "<div style='display: none;'>";
                //Create an instance; passing `true` enables exceptions
                if ($settings['enable_smtp'] == "true") {
                  $mail = new PHPMailer(true);

                  try {
                    //Server settings
                    $mail->SMTPDebug = 2; //Enable verbose debug output
                    $mail->isSMTP(); //Send using SMTP
                    $mail->Host = $smtp_host; //Set the SMTP server to send through
                    $mail->SMTPAuth = true; //Enable SMTP authentication
                    $mail->Username = $smtp_username; //SMTP username
                    $mail->Password = $smtp_password; //SMTP password
                    $mail->SMTPSecure = 'tls'; //Enable implicit TLS encryption
                    $mail->Port = $smtp_port; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom($smtp_from);
                    $mail->addAddress($email);

                    //Content
                    $mail->isHTML(true); //Set email format to HTML
                    $mail->Subject = 'no reply';
                    $mail->Body = 'Here is the verification link <b><a href="' . $settings["app_proto"] . $settings["app_url"] . '/auth/login/?verification=' . $code . '">' . $settings["app_proto"] . $settings["app_url"] . '/auth/login/?verification=' . $code . '</a></b>';

                    $mail->send();
                    echo 'Message has been sent';
                  } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo . "";
                  }
                  echo "</div>";
                  $msg = "<div class='alert alert-info'>We've send a verification link on your email address.</div>";
                } else {
                  echo "</div>";
                  $msg = "<div class='alert alert-info'>Thanks for using " . $settings['app_name'] . "</div>";
                  header('location: /auth/login');
                }

              } else {
                echo "</div>";
                $msg = "<div class='alert alert-danger'>Something wrong went.</div>";
              }
            } else {
              echo "</div>";
              $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
          }
        } else {
          // code for showing an error message goes here
          $errors = $resp->getErrorCodes();
        }

      }
    }
  } else {
    echo "</div>";
    $msg = "<div class='alert alert-danger'>CSRF verification faild!</div>";
  }
}
?>

<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
    integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <title>
    <?= $settings['app_name'] ?> | Register
  </title>
  <!-- CSS files -->
  <link href="/dist/css/tabler.min.css" rel="stylesheet" />
  <link href="/dist/css/tabler-flags.min.css" rel="stylesheet" />
  <link href="/dist/css/tabler-payments.min.css" rel="stylesheet" />
  <link href="/dist/css/tabler-vendors.min.css" rel="stylesheet" />
  <link href="/dist/css/demo.min.css" rel="stylesheet" />
  <link href="./dist/css/preloader.css" rel="stylesheet" />
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

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

<body class=" d-flex flex-column">
  <div id="preloader">
    <div id="loader"></div>
  </div>
  <script src="/dist/js/demo-theme.min.js"></script>
  <div class="page page-center">
    <div class="container container-tight py-4">
      <?php echo $msg; ?>
      <form class="card card-md" action="" method="post" autocomplete="off" novalidate>
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Create new account</h2>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" required class="form-control" name="name" value="<?php if (isset($_POST['submit'])) {
              echo $name;
            } ?>" placeholder="Enter name">
          </div>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" required name="email" value="<?php if (isset($_POST['submit'])) {
              echo $email;
            } ?>" placeholder="Enter email">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control" required name="password" placeholder="Password"
                autocomplete="off">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control" required name="confirm-password" placeholder="Repeat Password"
                autocomplete="off">
            </div>
          </div>
          <?php
          if ($settings['enable_rechapa2'] == "true") {
            ?>
            <div class="text-center">
              <div class="input-group input-group-flat" style="max-width: 300px; margin: 0 auto;">
                <br>
                <div class="g-recaptcha" data-sitekey="<?= $settings['rechapa2_site_key'] ?>"></div>
              </div>
            </div>
            <br>
            <?php
          } else {

          }
          ?>

          <div class="mb-3">
            <label class="form-check">
              <input type="checkbox" class="form-check-input" />
              <span class="form-check-label">Agree the <a href="./terms-of-service.html" tabindex="-1">terms and
                  policy</a>.</span>
            </label>
          </div>
          <?= $csrf->input('register-form'); ?>

          <div class="form-footer">
            <button type="submit" name="submit" class="btn btn-primary w-100">Create new account</button>
          </div>
        </div>
      </form>

      <div class="text-center text-muted mt-3">
        Already have account? <a href="/auth/login" tabindex="-1">Sign in</a>
      </div>
    </div>
  </div>
  <!-- Libs JS -->
  <!-- Tabler Core -->
  <script src="/dist/js/tabler.min.js" defer></script>
  <script src="/dist/js/demo.min.js" defer></script>
  <script src="./dist/js/preloader.js" defer></script>
  <?php
  if ($settings['enable_rechapa2'] == "true") {
    ?>
    <script>
      $('form').submit(function (e) {
        if ($("#g-recaptcha-response").val() === '') {
          e.preventDefault();
          alert("Please check the recaptcha");
        }
      });
    </script>
    <?php
  }
  ?>
</body>

</html>