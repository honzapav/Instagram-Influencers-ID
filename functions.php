<?php
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
