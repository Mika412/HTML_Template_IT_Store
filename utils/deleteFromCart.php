<?php
include('../db/db.php');
$prevloc=$_SERVER['HTTP_REFERER'];
session_start();

$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
$pid=$_GET['pid'];
$cid=$_SESSION['login']['id'];

if(isset($_SESSION['login'])){
    $query2 = "DELETE FROM `cart` WHERE `cart`.`client_id` ='".$cid."' AND `cart`.`product_id` ='".$pid."';";

    echo $query2;
    if(!($resultCart = @ mysql_query($query2,$db )))
        showerror();
}else{
    
    $pos = array_search($pid,  array_column($_SESSION['basket'], "pid"));
    unset($_SESSION['basket'][$pos]);
}
header('Location:'.$prevloc);
?>
