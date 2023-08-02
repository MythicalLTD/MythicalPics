<?php
try {
    require("../vendor/autoload.php");
}
catch(Exception $e) {
    die('Woopps this looks like your packages are broken or you installed the wrong version of AtoroPics please check your vendor folder"');
}

try {
    $router = new \Router\Router();

    $router->add('/', function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/index.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/");  
        }
    });

    $router->add('/auth/login', function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/auth/login.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/auth/login");  
        }
        
    });

    $router->add('/auth/register', function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/auth/register.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/auth/register");  
        }
        
    });

    $router->add('/auth/logout', function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/auth/logout.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/auth/logout");  
        }
    });
    
    $router->add('/i', function() {
        require("../index.php");
        require("../view/image/imageEmbed.php");
    });

    $router->add('/dashboard', function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/images.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/dashboard");  
        }
        
    });

    $router->add('/config', function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/embedConfig.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/config");  
        }
        
    });

    $router->add("/api/config", function() {
        require("../index.php");
        require("../api/sharex.php");
    });

    $router->add("/api/upload", function() {
        require("../index.php");
        require("../api/upload.php");
    });

    $router->add("/domains", function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/domainList.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/domains");  
        }
    });

    $router->add("/maintenance", function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/ui/maintenance.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/maintenance");  
        }
    });

    $router->add("/domain/add",function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/addDomain.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/domain/add");  
        }
    });

    $router->add("/admin",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/dashboard.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin");  
        }
    });

    $router->add("/admin/users",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/users/main.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/users");  
        }
    });

    $router->add("/admin/users/new",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/users/create.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/users/create");  
        }
    });

    $router->add("/admin/users/edit",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/users/edit.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/users/edit");  
        }
    });

    $router->add("/admin/users/delete",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/users/delete.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/users/delete");  
        }
    });

    $router->add("/admin/domains",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/domains/main.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/domains");  
        }
    });

    $router->add("/admin/domains/delete",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/domains/delete.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/domains/delete");  
        }
    });

    $router->add("/admin/domains/edit",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/domains/edit.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/domains/edit");  
        }
    });

    $router->add("/admin/api",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/api/main.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/api");  
        }
    });

    $router->add("/admin/api/create",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/api/create.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/api/create");  
        }
    });

    $router->add("/admin/api/delete",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/api/delete.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/api/delete");  
        }
    });

    $router->add("/admin/settings",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/settings/main.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/settings");  
        }
    });

    $router->add("/admin/update",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/settings/update.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/update");  
        }
    });

    $router->add("/admin/settings/mail",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/admin/settings/mail.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/settings/mail");  
        }
    });

    $router->add("/oldadmin",function() {
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/mainPage.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin");  
        }
    });

    $router->add("/oldadmin/settings",function(){
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/settingsPage.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/settings");  
        }
    });
    

    $router->add("/oldadmin/settings/advanced",function(){
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/advancedsettingsPage.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/settings/advanced");  
        }
    });

    $router->add("/oldadmin/users/edit",function(){
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/user/edit.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/users/edit");  
        }
    });

    $router->add("/oldadmin/domains",function(){
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/doaminsPage.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/domains");  
        }
    });

    $router->add("/oldadmin/users/delete",function(){
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/user/delete.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/users/delete");  
        }
    });

    $router->add("/oldadmin/settings/mail",function(){
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/emailPage.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/settings/mail");  
        }
    });

    $router->add("/oldadmin/api",function(){
        require('../index.php');
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/apiPage.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/api");  
        }
    });

    $router->add("/oldadmin/api/new", function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/api/create.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/api/new");  
        }
        
    });

    $router->add("/oldadmin/users", function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/usersPage.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/users");  
        }
        
    });

    
    $router->add("/oldadmin/users/new", function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/user/create.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/users/new");  
        }
        
    });

    $router->add("/oldadmin/domains", function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/doaminsPage.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/domains");  
        }
        
    });

    $router->add("/oldadmin/domains/edit", function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../view/old_admin/domain/edit.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/oldadmin/domains/edit");  
        }
        
    });

    $router->add("/admin/reports", function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            echo '<font color="red">This thing is not done yet do not try to bypass or enable this function yet!!</font>';
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/admin/reports");  
        }
        
    });

    $router->add("/api/delete", function() {
        require("../index.php");
        if ($_SERVER['HTTP_HOST'] == $settings['app_url'])
        {
            require("../api/delete.php");
        } else {
          header('location: '.$settings['app_proto'].$settings['app_url']."/api/delete");  
        }
    });

    $router->add("/(.*)", function() {
        require("../index.php");
        require("../view/errors/404.php");
    });

    $router->route();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
