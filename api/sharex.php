<?php
header('Content-Type: application/json');
require('../class/session.php');
$userdb = $conn->query("SELECT * FROM mythicalpics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();
$sharexconfigfile = '{
  "Version": "15.0.0",
  "Name": "'.$_ENV['app_name'].'",
  "DestinationType": "ImageUploader, TextUploader, FileUploader",
  "RequestMethod": "POST",
  "RequestURL": "https://'.$_ENV['app_url'].'/api/upload",
  "Body": "MultipartFormData",
  "Arguments": {
    "api_key": "'.$userdb["api_key"].'"
  },
  "FileFormName": "file",
  "URL": "{response}"
}
';
$filenamet = time();
$file = $_ENV['app_name'].'_'.$userdb['username'].'_SharexConfig.sxcu';
file_put_contents($file, $sharexconfigfile);
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=".basename($file));
header("Content-Length: ".filesize($file));
readfile($file);
unlink($file);
exit;
?>