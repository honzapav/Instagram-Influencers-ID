<?php

 session_start();
require 'Instagram.php';
use MetzWeb\Instagram\Instagram;
// initialize class
$instagram = new Instagram(array(
      'apiKey'      => 'your-api-key',
      'apiSecret'   => 'your-api-secret',
      'apiCallback' => 'your-callback-url' //must point to success.php
    ));
   
// receive OAuth code parameter
$code = $_GET['code'];
// check whether the user has granted access
if (isset($code)) {
  // receive OAuth token object
  $data = $instagram->getOAuthToken($code);
  $_SESSION["inst_acc_token"]=$data->access_token;
    header('Location: index.php');
    die();
}

?>
