<?php
require 'init.php';
if(isset($_GET['verze'])){
    if($_GET['verze']=="v2"){
        mysql_query("DELETE FROM wp_instaapi_vazby2 where zdroj='".$_GET['zdroj']."'");
        header('Location: index.php');
    }else if($_GET['verze']=="users_v2"){
        mysql_query("DELETE FROM wp_instaapi_userdata");
        header('Location: index.php');
    }
}
?>
