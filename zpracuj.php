<?php
session_start();
set_time_limit(300); 
require 'init.php';
$out=array();
if(isset($_GET['username'])){
    $userid=getInstaID($_GET['username']);
    $userdata=$instagram->getUserMedia($userid,10);
    if(isset($_GET['page'])){
        for($i=0;$i<$_GET['page'];$i++){
            $userdata=$instagram->pagination($userdata,10);
        }
    }

            $fotky=$userdata->data;
            foreach($fotky as $value){
                $likes_fotky=$instagram->getMediaLikes($value->id);
                foreach ($likes_fotky->data as $likes){
                    //1) lajker->autor
                    $out["lajker->autor"][]=$likes->username."@".$_GET['username']."@".($value->id);
                    $lajker[$value->id][]=$likes->username;
                }
                $komenty_fotky=$instagram->getMediaComments($value->id);
                foreach ($komenty_fotky->data as $comments){
                    //2) komentator->autor
                    $out["komentator->autor"][]=$comments->from->username."@".$_GET['username']."@".($value->id);
                    $komentator[$value->id][]=$comments->from->username;
                    $mentions_fotka_komentar=najdiMention($comments->text);
                    if($mentions_fotka_komentar){
                        foreach($mentions_fotka_komentar as $m_f_k){
                        //6)  autor komentare->mention
                        $out["autor komentare->mention"][]=$comments->from->username."@".$m_f_k."@".($value->id);
                        }
                    }
                        
                }
                $mentions_fotka=najdiMention($value->caption->text);
                if($mentions_fotka){
                    foreach($mentions_fotka as $m_f){
                        //5)  auto->mention
                        $out["autor->mention"][]=$_GET['username']."@".$m_f."@".($value->id);
                    }
                }
  
            };
        //3) lajker->lajker
       /* foreach ($lajker as $lajkeri_fotky){
            foreach ($lajkeri_fotky as $l1){
                foreach ($lajkeri_fotky as $l2){
                if($l1!=$l2)
                    $out["l-l"][]=$l1."@".$l2;
                }
            }
        }*/
        foreach ($lajker as $key=>$lajkeri_fotky){
            if(count($lajkeri_fotky)>1)
           for($i=count($lajkeri_fotky);$i>=0;$i--){
               if($lajkeri_fotky[$i-1]!=$lajkeri_fotky[$i-2]&&$lajkeri_fotky[$i-1]&&$lajkeri_fotky[$i-2])
                $out["lajker->lajker"][]=$lajkeri_fotky[$i-1]."@".$lajkeri_fotky[$i-2]."@".$key;
           }
        }
        //4) komentátor ->komentátor 
        foreach ($komentator as $key=>$komentatori_fotky){
            if(count($komentatori_fotky)>1)
           for($i=count($komentatori_fotky);$i>=0;$i--){
               if($komentatori_fotky[$i-1]!=$komentatori_fotky[$i-2]&&$komentatori_fotky[$i-1]&&$komentatori_fotky[$i-2])
                $out["komentator-komentator"][]=$komentatori_fotky[$i-1]."@".$komentatori_fotky[$i-2]."@".$key;
           }
        }
           
           foreach($out as $key=>$uroven){
               foreach ($uroven as $vazba){
                   $user=explode("@",$vazba);
                   ulozUsername($user[0]);
                   ulozUsername($user[1]);
                   ulozVazbuUzivatele2($user[0],$user[1],$_GET['username'],$key,$user[2]);
               }
           }
           if(!isset($_GET['page']))$page=1;else $page=$_GET['page']+1;
           if($page<6)header('Location: zpracuj.php?username='.$_GET['username'].'&page='.$page);
            else header('Location: index.php?ok=1');
            }            
            

?>
