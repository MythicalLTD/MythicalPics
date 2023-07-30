<?php 
$enable_template= "false";
$protocol = 'http://';
$domain = $_SERVER['HTTP_HOST'];
$currentURL = $protocol . $domain;


if ($enable_template == "true")
{
  ?>
  <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./dist/css/preloader.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>MythicalPics | Home</title>
</head>

<body>
<div id="preloader">
        <div id="loader"></div>
    </div>
    <center>
        <p>Welcome to MythicalPics</p>
        <p>This is the default template for the instalation</p>
        <p>Make sure to replace this with your custom build template</p>
        <p>To upload the template make sure to go in <code>/view/index.php</code></p>
        <p>If you don't need a custom template you can allways disable it from /view/index.php</p>
        <p>At the first line</p>
    </center>
</body>
<script src="./dist/js/preloader.js" defer></script>
</html>
  <?php
}
else
{
    header('location: /dashboard');
}
?>
