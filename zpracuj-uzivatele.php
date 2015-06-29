<?php
session_start();
set_time_limit(300); 
require_once 'Instagram.php';
require 'functions.php';
use MetzWeb\Instagram\Instagram;
$instagram = new Instagram(array(
      'apiKey'      => 'your-api-key',
      'apiSecret'   => 'your-api-secret',
      'apiCallback' => 'your-callback-url' //must point to success.php
    ));
$instagram->setAccessToken($_SESSION["inst_acc_token"]);
$sql=mysql_query("SELECT * FROM wp_instaapi_userdata WHERE instagram_id='' AND existuje=1 limit 0,30");
while($data=mysql_fetch_assoc($sql)){
    $userid=getInstaID($data['username']);
    if($userid!="00000000"){
        $userdata=$instagram->getUser($userid);
        $out=$userdata->data;
        if(!$out->id) neexistujeUser($data['username']);
        ulozUserdata($data['username'],$out->id,$out->counts->followed_by,$out->counts->follows,$out->counts->media,$out->bio,$out->website,$out->full_name,$out->profile_picture);
    }else{
        neexistujeUser($data['username']);
    }
}
if(mysql_num_rows($sql)==0) header('Location: indexv2.php?ok=1');
 if(!isset($_GET['page']))$page=1;else $page=$_GET['page']+1;
           if($page<10)header('Location: zpracuj-uzivatele.php?page='.$page);
            else header('Location: indexv2.php?ok=1');
            
            
            
/*$zdroj="karelnox";
$sql=mysql_query("SELECT * FROM wp_instaapi_vazby2 v right join wp_instaapi_userdata ud on v.userA=ud.username WHERE zdroj='".$zdroj."' AND instagram_id=''" );
while($data=mysql_fetch_assoc($sql)){
    $userid=getInstaID($data['userA']);
    $userdata=$instagram->getUser($userid);
    $out=$userdata->data;
    ulozUserdata($data['userA'],$out->id,$out->counts->followed_by,$out->counts->follows,$out->counts->media,$out->bio,$out->website,$out->full_name,$out->profile_picture);
}
$sql=mysql_query("SELECT * FROM wp_instaapi_vazby2 v right join wp_instaapi_userdata ud on v.userB=ud.username WHERE zdroj='".$zdroj."' AND instagram_id='' " );
while($data2=mysql_fetch_assoc($sql2)){
    $userid=getInstaID($data['userB']);
    $userdata=$instagram->getUser($userid);
    $out=$userdata->data;
    ulozUserdata($data['userA'],$out->id,$out->counts->followed_by,$out->counts->follows,$out->counts->media,$out->bio,$out->website,$out->full_name,$out->profile_picture);
}
vp($data);*/
/*while($data=mysql_fetch_assoc($sql)){
        $do_csv[]=array($data['userA'],$data['userB']);
    }*/
/*$userid=getInstaID($username);
$userdata=$instagram->getUser($userid);
$out=$userdata->data;
ulozUserdata($username,$out->id,$out->counts->followed_by,$out->counts->follows,$out->counts->media,$out->bio,$out->website,$out->full_name,$out->profile_picture);
*/
?>
