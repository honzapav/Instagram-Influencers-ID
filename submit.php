<?php
require 'functions.php';
if($_GET['typ']=="vazby"){
    $do_csv[]=array("User A","User B");
    $sql=mysql_query("SELECT zdroj,username FROM wp_instaapi where zdroj='".$_GET['zdroj']."' AND smer='follows' AND username!='".$_GET['zdroj']."'");
    while($data=mysql_fetch_assoc($sql)){
        $do_csv[]=array($data['zdroj'],$data['username']);
    }
    $sql=mysql_query("SELECT zdroj,username FROM wp_instaapi where zdroj='".$_GET['zdroj']."' AND smer='followedby' AND username!='".$_GET['zdroj']."'");
    while($data=mysql_fetch_assoc($sql)){
        $do_csv[]=array($data['username'],$data['zdroj']);
    }
    array_to_csv_download($do_csv,"vazby-".$_GET['zdroj'].".csv");
}
if($_GET['typ']=="uzivatele"){
    $do_csv[]=array("Instagram ID","username","Followers","Followed by","F/F ratio","Media","Likes","Comments","Engagement per post ","Date","Hashtags","Bio","Web");
    $sql=mysql_query("SELECT * FROM wp_instaapi where zdroj='".$_GET['zdroj']."' group by id_inst");
    while($data=mysql_fetch_assoc($sql)){
        $do_csv[]=array($data['id_inst'],$data['username'],$data['followers'],$data['followedby'],$data['f_fby'],$data['media'],$data['likes'],$data['coments'],$data['l_c'],$data['date'],$data['tags'],$data['bio'],$data['url']);
    }
   
   array_to_csv_download($do_csv,"uzivatele-".$_GET['zdroj'].".csv");
}
if($_GET['typ']=="vazby_nove"){
    $do_csv[]=array("User A","User B");
    $sql=mysql_query("SELECT * FROM wp_instaapi_vazby where zdroj='".$_GET['zdroj']."'");
    while($data=mysql_fetch_assoc($sql)){
        $do_csv[]=array($data['userA'],$data['userB']);
    }
    array_to_csv_download($do_csv,"vazby_nove-".$_GET['zdroj'].".csv");
}

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
