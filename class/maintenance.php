<?php 
if ($_ENV['app_maintenance'] == "false") {
    
}
else
{
    if ($userdb['admin'] == "true") {
        
    }
    else
    {
        header('location: /maintenance');
    }
}
?>