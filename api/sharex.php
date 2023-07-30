<?php
header('Content-Type: application/json');
require('../class/session.php');
$userdb = $conn->query("SELECT * FROM atoropics_users WHERE api_key = '" . mysqli_real_escape_string($conn, $_SESSION["api_key"]) . "'")->fetch_array();
$query = "SELECT domain FROM atoropics_domains WHERE ownerkey = '".$_SESSION['api_key']."'";
$result = $conn->query($query);
if ($result) {
  $row = $result->fetch_assoc();
  $domain = $row['domain'];
$sharexconfigfile = '{
  "Version": "15.0.0",
  "Name": "'.$settings['app_name'].'",
  "DestinationType": "ImageUploader, TextUploader, FileUploader",
  "RequestMethod": "POST",
  "RequestURL": "https://'.$domain.'/api/upload",
  "Body": "MultipartFormData",
  "Arguments": {
    "api_key": "'.$userdb["api_key"].'"
  },
  "FileFormName": "file",
  "URL": "{response}"
}
';
} else {
$sharexconfigfile = '{
  "Version": "15.0.0",
  "Name": "'.$settings['app_name'].'",
  "DestinationType": "ImageUploader, TextUploader, FileUploader",
  "RequestMethod": "POST",
  "RequestURL": "'.$settings['app_proto'].$settings['app_url'].'/api/upload",
  "Body": "MultipartFormData",
  "Arguments": {
    "api_key": "'.$userdb["api_key"].'"
  },
  "FileFormName": "file",
  "URL": "{response}"
}
';
}

$filenamet = time();
$file = $settings['app_name'].'_'.$userdb['username'].'_SharexConfig.sxcu';
file_put_contents($file, $sharexconfigfile);
header("Content-type: application/force-download");
header("Content-Disposition: attachment; filename=".basename($file));
header("Content-Length: ".filesize($file));
readfile($file);
unlink($file);
exit;
?>