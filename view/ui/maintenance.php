<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Maintenance mode -
        <?= $settings['app_name'] ?>
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
    <link href="./dist/css/preloader.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: Inter, -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
    </style>
    <style type="text/css" id="operaUserStyle"></style>
</head>

<body class="border-top-wide border-primary d-flex flex-column theme-dark">
    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="empty">
                <div class="empty-img"><img src="/dist/img/undraw_quitting_time_dm8t.svg" height="128" alt="">
                </div>
                <p class="empty-title">Temporarily down for maintenance</p>
                <p class="empty-subtitle text-muted">
                    Sorry for the inconvenience but we’re performing some maintenance at the moment. We’ll be back
                    online shortly!
                </p>
                <div class="empty-action">
                    <a href="./." class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <line x1="5" y1="12" x2="11" y2="18"></line>
                            <line x1="5" y1="12" x2="11" y2="6"></line>
                        </svg>
                        Take me home
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js" defer=""></script>
</body>

</html>