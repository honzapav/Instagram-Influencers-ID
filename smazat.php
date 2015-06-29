<?php
require 'functions.php';
if(isset($_GET['verze'])){
    if($_GET['verze']=="v1"){
        mysql_query("DELETE FROM wp_instaapi_vazby where zdroj='".$_GET['zdroj']."'");
    	mysql_query("DELETE FROM wp_instaapi_vazby_progress where zdroj='".$_GET['zdroj']."'");
        header('Location: http://www.yourdomain.com');
    }else if($_GET['verze']=="v2"){
        mysql_query("DELETE FROM wp_instaapi_vazby2 where zdroj='".$_GET['zdroj']."'");
        header('Location: http://www.yourdomain.comindexv2.php');
    }else if($_GET['verze']=="users_v2"){
        mysql_query("DELETE FROM wp_instaapi_userdata");
        header('Location: http://www.yourdomain.com/indexv2.php');
    }
}
?>
