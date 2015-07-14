<?php
session_start();
require 'init.php';
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
