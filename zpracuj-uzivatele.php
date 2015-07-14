<?php
session_start();
set_time_limit(300); 
require 'init.php';
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
if(mysql_num_rows($sql)==0) header('Location: index.php?ok=1');
 if(!isset($_GET['page']))$page=1;else $page=$_GET['page']+1;
           if($page<10)header('Location: zpracuj-uzivatele.php?page='.$page);
            else header('Location: index.php?ok=1');
            
            

?>
