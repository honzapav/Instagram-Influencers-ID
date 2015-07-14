<?php
//requires
require_once 'Instagram.php';
require 'functions.php';
use MetzWeb\Instagram\Instagram;
    
//zakladni data
define('url_aplikace', 'here comes the app's url');

//databaze
mysql_connect("your-db-server", "your-db-username", "db-password") or die(mysql_error());
mysql_select_db("your-db-name") or die(mysql_error());
mysql_query("SET CHARACTER SET utf8");

//instagram api
$instagram = new Instagram(array(
      'apiKey'      => 'here comes the api key',
      'apiSecret'   => 'here comes the api secret',
      'apiCallback' => url_aplikace.'success.php'
    ));
    
$instagram->setAccessToken($_SESSION["inst_acc_token"]);