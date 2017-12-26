<?php
include('../db/db.php');

$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
$idProduct = $_GET['pid'];
$prevloc=$_SERVER['HTTP_REFERER'];
session_start();

//session_destroy();
//unset($_SESSION['basket']);
if(isset($_SESSION['login'])){
  $query1 = "INSERT INTO `cart` (`client_id`, `product_id`, `quantity`) VALUES ('".$_SESSION['login']['id']."', '".$idProduct."', '1') ON DUPLICATE KEY UPDATE quantity = quantity+1;";
  
  if(!($resultCart = @ mysql_query($query1,$db )))
    showerror();
  header('Location:'.$prevloc);
}else{
  if(isset($_SESSION['basket'])) {
    $pos = array_search($idProduct,  array_column($_SESSION['basket'], "pid"));
    if($pos!=NULL){
      $_SESSION['basket'][$pos]["quantity"] += 1;
    }else
      array_push($_SESSION['basket'], array("pid" => $idProduct, "quantity" => 1));
  }else{
    $_SESSION['basket']=array();
    array_push($_SESSION['basket'], array("pid" => $idProduct, "quantity" => 1));
  }
  
  header('Location:'.$prevloc);
}
?>
