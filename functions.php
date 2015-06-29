<?php
mysql_connect("your-seerver", "your-db-username", "your-db-password") or die(mysql_error());
mysql_select_db("your-db-name") or die(mysql_error());
mysql_query("SET CHARACTER SET utf8");

function getInstaID($username)
{

    $username = strtolower($username); // sanitization
    $token = "InsertThatHere";
    $url = "https://api.instagram.com/v1/users/search?q=".$username."&access_token=".$_SESSION["inst_acc_token"];
    $get = file_get_contents($url);
    $json = json_decode($get);

    foreach($json->data as $user)
    {
        if($user->username == $username)
        {
            return $user->id;
        }
    }

    return '00000000'; // return this if nothing is found
}
function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w'); 
    // loop over the input array
    foreach ($array as $line) { 
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter); 
    }
    // rewrind the "file" with the csv lines
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachement; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}
function ulozUzivatele($id,$username,$followers,$followedby,$f_fby,$media,$likes=null,$comments=null,$l_c=null,$date=null,$tags=null,$bio,$url,$zdroj,$smer){
    $sql=mysql_query("SELECT * wp_instaapi where id_inst='".$id."' AND smer='".$smer."' AND zdroj='".$zdroj."'" );
    if(mysql_num_rows($sql)==0){
        mysql_query("INSERT INTO wp_instaapi (id_inst,username,followers,followedby,f_fby,media,likes,comments,l_c,date,tags,bio,url,zdroj,smer) VALUES (
        '".$id."',
        '".$username."',
        '".$followers."',
        '".$followedby."',
        '".$f_fby."',
        '".$media."',
        '".$likes."',
        '".$comments."',
        '".$l_c."',
        '".$date."',
        '".$tags."',
        '".$bio."',
        '".$url."',
        '".$zdroj."',
        '".$smer."'
        )");
    }
}
function uzJeVTabulce($id){
    $sql=mysql_query("SELECT * FROM wp_instaapi where id=".$id);
    if(mysql_num_rows($sql)>0)return true;
    else return false;
}
function ulozProgress($co,$koho,$paginace){
    $sql=mysql_query("SELECT * FROM wp_instaapi_progress where co='".$co."' AND koho='".$koho."'");
    if(mysql_num_rows($sql)==0){
         if($paginace)
            mysql_query("INSERT INTO wp_instaapi_progress (co,koho,paginace) VALUES ('".$co."','".$pruchod."','".$koho."','".$paginace."')");
         else
             mysql_query("INSERT INTO wp_instaapi_progress (co,koho) VALUES ('".$co."','".$koho."')");
    }
        
    else{
        if($paginace)
            mysql_query("UPDATE wp_instaapi_progress set paginace='".$paginace."' where co='".$co."' AND koho='".$koho."'");
    }
};
function paginaceEnDe($data,$typ){
    if($typ=="encode"){
        $out=$data->next_url."@@@".$data->next_cursor;
        return $out;
    }else{
        $pole=explode("@@@",$data);
        $imitace_paginace->pagination->next_url=$pole[0];
        $imitace_paginace->pagination->next_cursor=$pole[1];
        return $imitace_paginace;
    }
    
}
function pokracovani($co,$koho){
    $sql=mysql_query("SELECT paginace FROM wp_instaapi_progress where co='".$co."' AND koho='".$koho."'");
    if(mysql_num_rows($sql)==0)return false;
    else{
        if(mysql_result($sql,0,0)!="@@@"){
            $out['paginace']=paginaceEnDe(mysql_result($sql,0,0),"decode");
        }else{
              $out['paginace']="konec";
        }
            return $out;
    }
}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}
function ulozVazbuUzivatele($userA,$userB,$user0){
	 $sql=mysql_query("SELECT * FROM wp_instaapi_vazby where userA='".$userA."' AND userB='".$userB."' AND zdroj='".$user0."' ");
    if(mysql_num_rows($sql)==0)
		mysql_query("INSERT INTO wp_instaapi_vazby (userA,userB,zdroj) VALUES ('".$userA."','".$userB."','".$user0."')");
	$sql2=mysql_query("SELECT * FROM wp_instaapi_vazby where userA='".$user0."' AND userB='".$userB."' AND zdroj='".$user0."' ");
    if(mysql_num_rows($sql2)==0)
		mysql_query("INSERT INTO wp_instaapi_vazby (userA,userB,zdroj) VALUES ('".$user0."','".$userB."','".$user0."')");
}
function ulozProgressVazby($zdroj,$paginace1,$paginace2,$ukazatel,$klic,$pruchod,$followeru){
    $sql=mysql_query("SELECT * FROM wp_instaapi_vazby_progress where zdroj='".$zdroj."'");
    if(mysql_num_rows($sql)==0){
         if($paginace1||$paginace2)
            mysql_query("INSERT INTO wp_instaapi_vazby_progress (zdroj,paginace1,paginace2,ukazatel,klic,pruchod,followeru) VALUES ('".$zdroj."','".$paginace1."','".$paginace2."','".$ukazatel."','".$klic."','".$pruchod."','".$followeru."')");
         else
             mysql_query("INSERT INTO wp_instaapi_vazby_progress (zdroj,ukazatel,klic,pruchod,followeru) VALUES ('".$zdroj."','".$ukazatel."','".$klic."','".$pruchod."','".$followeru."')");
    }
        
    else{
        if($paginace1||$paginace2)
            mysql_query("UPDATE wp_instaapi_vazby_progress set paginace1='".$paginace1."',paginace2='".$paginace2."',ukazatel='".$ukazatel."',klic='".$klic."',pruchod='".$pruchod."' where zdroj='".$zdroj."'");
    }
};
function pokracovaniVazby($sloupec,$koho){
    $sql=mysql_query("SELECT paginace1,paginace2,klic FROM wp_instaapi_vazby_progress where zdroj='".$koho."'");
    if(mysql_num_rows($sql)==0)return false;
    else{
        if(mysql_result($sql,0,$sloupec)!="@@@"){
            $out["paginace"]=paginaceEnDe(mysql_result($sql,0,$sloupec),"decode");
        }else{
              $out["paginace"]="konec";
        }
        $out["klic"]=mysql_result($sql,0,2);
            return $out;
    }
}

/**V2**/
function vp($string){
    echo "<pre>";
    print_r($string);
    echo "</pre>";
    echo "<hr/>";
}        
function najdiMention($string){
    $out=array();
    $data=explode("@",$string);//najdu teoreticky mention
    foreach (array_slice($data,1) as $value){
        $data2=explode(" ",$value);
        $out[]=$data2[0];
    }
    return $out;
    }         
    
 function ulozVazbuUzivatele2($userA,$userB,$user0,$vazba,$id_fotky){
     $sql=mysql_query("SELECT * FROM wp_instaapi_vazby2 where userA='".$userA."' AND userB='".$userB."' AND zdroj='".$user0."' AND vazba='".$vazba."'  AND id_fotky='".$id_fotky."' ");
    if(mysql_num_rows($sql)==0)
        mysql_query("INSERT INTO wp_instaapi_vazby2 (userA,userB,zdroj,vazba,id_fotky) VALUES ('".$userA."','".$userB."','".$user0."','".$vazba."','".$id_fotky."')");
}   
function ulozUsername($username){
      $sql=mysql_query("SELECT * FROM wp_instaapi_userdata where username='".$username."' ");
    if(mysql_num_rows($sql)==0)
        mysql_query("INSERT INTO wp_instaapi_userdata (username) VALUES ('".$username."')");
}
function ulozUserdata($username,$i_id,$fb,$f,$m,$b,$w,$fn,$pp){
    mysql_query("UPDATE wp_instaapi_userdata SET
        instagram_id= '".$i_id."',
        followed_by=  '".$fb."',
        follows= '".$f."',
        media='".$m."',
        bio= '".str_replace("'","\'",$b)."',
        website= '".$w."',
        fulname= '".str_replace("'","\'",$fn)."',
        profile_picture= '".$pp."'
    where username= '".$username."'");
       
}
function neexistujeUser($username){
     mysql_query("UPDATE wp_instaapi_userdata SET
        existuje=0
    where username= '".$username."'");
}
function pocetUserdata($zdroj=null){
    if($zdroj)
        $sql=mysql_query("SELECT * FROM wp_instaapi_userdata where username='".$username."' ");
    else{ 
        $sql1=mysql_query("SELECT * FROM wp_instaapi_userdata where existuje=1");
        $sql2=mysql_query("SELECT * FROM wp_instaapi_userdata where instagram_id<>'' AND existuje=1");
        $out['kompletni']=mysql_num_rows($sql2);
        $out['celkem']=mysql_num_rows($sql1);
    }
    return $out;
}
?>
