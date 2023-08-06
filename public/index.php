<?php
try {
    if (file_exists('../vendor/autoload.php')) { 
        require("../vendor/autoload.php");
    } else {
        die('Hello, it looks like you did not run:  "<code>composer install --no-dev --optimize-autoloader</code>". Please run that and refresh the page');
    }
} catch (Exception $e) {
    die('Hello, it looks like you did not run:  <code>composer install --no-dev --optimize-autoloader</code> Please run that and refresh');
}
//Enable old admin
$enable_old_admin = false;
//Enable old UI
$enable_old_ui = true;
try {
    $router = new \Router\Router();
    if ($enable_old_ui == true) {
        $router->add('/', function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_ui/index.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/");
            }
        });

        $router->add('/auth/login', function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_ui/auth/login.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/auth/login");
            }

        });

        $router->add('/auth/register', function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_ui/auth/register.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/auth/register");
            }

        });

        $router->add('/auth/logout', function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_ui/auth/logout.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/auth/logout");
            }
        });

        $router->add('/i', function () {
            require(__DIR__."/../include/main.php");
            require("../view/old_ui/image/imageEmbed.php");
        });

        $router->add('/dashboard', function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_ui/images.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/dashboard");
            }

        });

        $router->add('/config', function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_ui/embedConfig.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/config");
            }

        });

        $router->add("/domains", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_ui/domainList.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/domains");
            }
        });

        $router->add("/maintenance", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_ui/ui/maintenance.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/maintenance");
            }
        });

        $router->add("/domain/add", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_ui/addDomain.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/domain/add");
            }
        });

        $router->add("/(.*)", function () {
            require(__DIR__."/../include/main.php");
            require("../view/old_ui/errors/404.php");
        });

    } else {

    }
    //API 
    $router->add('/api/daemon/info', function () {
        require(__DIR__."/../include/main.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
            require("../api/daemon/info.php");
        } else {
            header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/api/daemon/info");
        }
    });
    //ADMIN
    if ($enable_old_admin == true) {
        $router->add("/admin", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/mainPage.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin");
            }
        });

        $router->add("/admin/settings", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/settingsPage.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/settings");
            }
        });


        $router->add("/admin/settings/advanced", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/advancedsettingsPage.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/settings/advanced");
            }
        });

        $router->add("/admin/users/edit", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/user/edit.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/users/edit");
            }
        });

        $router->add("/admin/domains", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/doaminsPage.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/domains");
            }
        });

        $router->add("/admin/users/delete", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/user/delete.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/users/delete");
            }
        });

        $router->add("/admin/settings/mail", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/emailPage.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/settings/mail");
            }
        });

        $router->add("/admin/api", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/apiPage.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/api");
            }
        });

        $router->add("/admin/api/new", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/api/create.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/api/new");
            }

        });

        $router->add("/admin/users", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/usersPage.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/users");
            }

        });


        $router->add("/admin/users/new", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/user/create.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/users/new");
            }

        });

        $router->add("/admin/domains", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/doaminsPage.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/domains");
            }

        });

        $router->add("/admin/domains/edit", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/old_admin/domain/edit.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/domains/edit");
            }

        });
    } else {
        $router->add("/admin/reports", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                echo '<font color="red">This thing is not done yet do not try to bypass or enable this function yet!!</font>';
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/reports");
            }

        });
        $router->add("/admin", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/dashboard.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin");
            }
        });

        $router->add("/admin/users", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/users/main.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/users");
            }
        });

        $router->add("/admin/users/new", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/users/create.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/users/create");
            }
        });

        $router->add("/admin/users/edit", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/users/edit.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/users/edit");
            }
        });

        $router->add("/admin/users/delete", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/users/delete.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/users/delete");
            }
        });

        $router->add("/admin/domains", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/domains/main.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/domains");
            }
        });

        $router->add("/admin/domains/delete", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/domains/delete.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/domains/delete");
            }
        });

        $router->add("/admin/domains/edit", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/domains/edit.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/domains/edit");
            }
        });

        $router->add("/admin/api", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/api/main.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/api");
            }
        });

        $router->add("/admin/api/create", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/api/create.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/api/create");
            }
        });

        $router->add("/admin/api/delete", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/api/delete.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/api/delete");
            }
        });

        $router->add("/admin/settings", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/settings/main.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/settings");
            }
        });

        $router->add("/admin/update", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/settings/update.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/update");
            }
        });

        $router->add("/admin/settings/mail", function () {
            require('../include/main.php');
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/settings/mail.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/settings/mail");
            }
        });

        $router->add("/admin/nodes", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/nodes/main.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/nodes");
            }

        });

        $router->add("/admin/nodes/new", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/nodes/create.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/nodes/new");
            }

        });

        $router->add("/admin/nodes/info", function () {
            require(__DIR__."/../include/main.php");
            if ($_SERVER['HTTP_HOST'] == $settings['app_url']) {
                require("../view/admin/nodes/info.php");
            } else {
                header('location: ' . $settings['app_proto'] . $settings['app_url'] . "/admin/nodes/info");
            }

        });
    }


    $router->route();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>