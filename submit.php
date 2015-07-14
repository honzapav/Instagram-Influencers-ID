<?php
require 'init.php';
if($_GET['typ']=="vazby_v2"){
    $do_csv[]=array("User A","User B","Vazba","ID Fotky");
    $sql=mysql_query("SELECT * FROM wp_instaapi_vazby2 where zdroj='".$_GET['zdroj']."'");
    while($data=mysql_fetch_assoc($sql)){
        $do_csv[]=array($data['userA'],$data['userB'],$data['vazba'],$data['id_fotky']);
    }
    array_to_csv_download($do_csv,$_GET['zdroj'].".csv");
}
if($_GET['typ']=="uzivatele_v2"){
    $do_csv[]=array("username","followed_by","follows","media","bio","website","fulname","profile_picture");
    $sql=mysql_query("SELECT * FROM wp_instaapi_userdata where existuje=1");
    while($data=mysql_fetch_assoc($sql)){
        $do_csv[]=array($data["username"],$data["followed_by"],$data["follows"],$data["media"],$data["bio"],$data["website"],$data["fulname"],$data["profile_picture"]);
    }
    array_to_csv_download($do_csv,"uzivatele_v2.csv");
}
?>
