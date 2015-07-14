<?php
session_start();
set_time_limit(300);
require 'init.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
    <title>InstagramTool</title>    
    <link rel="stylesheet" href="font-awesome.min.css">
    <link rel="stylesheet" href="style.css"/>
</head><body><div id="wrapper">
    <h1>- <i class="fa fa-instagram"></i> InstagramTool -</h1>
    <?if(isset($_GET['ok'])){?><div class="okay">Načtení proběhlo v pořádku! Yay!</div><?}?>
    <hr/>
<?if(!@$_SESSION["inst_acc_token"])
    echo "<p style='text-align:center;'><a href='{$instagram->getLoginUrl()}'>Login with Instagram</a></p>";
else {?>
    <h2>Vstupní data</h2>
    <form id="inputform" action="zpracuj.php">
        <input type="text" name="username" class="vypln" placeholder="zadejte instagram username"><br/>
        <input type="submit" value="odeslat" class="tlacitko">
    </form >
    <hr/>    



<h2>Výstupní data</h2>
<table id="vystupnidata">
    <tr>
        <td  style="width:66%;vertical-align:top">
            <table style="width:90%;margin-top:20px">
<?
$sql=mysql_query("SELECT zdroj,count(*) as pocet FROM wp_instaapi_vazby2 group by zdroj");
while($data=mysql_fetch_assoc($sql)){
    echo "<tr><td><a href='submit.php?typ=vazby_v2&zdroj=".$data['zdroj']."''>".$data['zdroj']."</a></td><td>".$data['pocet']." vazeb </td><td><a href='submit.php?typ=vazby_v2&zdroj=".$data['zdroj']."''><i class=\"fa fa-file-excel-o\" title='Stáhnout'></i></a></td><td><a href='smazat.php?verze=v2&zdroj=".$data['zdroj']."'' style='color:red'><i class='fa fa-close fa-lg cervena' title='Smazat'></i></a></td></tr>";
            }
?>
</table>
        </td>
        <td  style="width:33%;text-align:center;vertical-align:top">
            <h3>Kompletní uživatelská data</h3>
            <?
            $pocty=pocetUserdata();
            echo "<strong>".$pocty['kompletni']."/". $pocty['celkem']."</strong>";
            echo "  (".round($pocty['kompletni']/$pocty['celkem']*100,2)."%)";
            ?>
           <br/>   <br/> <a href='submit.php?typ=uzivatele_v2'>Stáhnout kompletní uživatelská data</a>
           <br/>   
            <a href="zpracuj-uzivatele.php"><div class="tlacitko" style="margin-top:10px;padding:8px 12px">Načíst další uživatelská data</div></a>
            <br/><br/> <a href='smazat.php?verze=users_v2' style="color:red;font-weight:bold">SMAZAT UŽIVATELSKÁ DATA</a><br/>
        </td>
    </tr>
</table>
<?}?>
</body>
</html>



