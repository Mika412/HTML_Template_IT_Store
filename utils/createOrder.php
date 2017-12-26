<?php
include('../db/db.php');
echo "Test";

$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 

$prevloc=$_SERVER['HTTP_REFERER'];
session_start();

if(isset($_SESSION['login'])){
   $date = date("Y-m-d H:i:s");
  $query1 = "INSERT INTO `orders` (`customer_id`, `created_at`) VALUES ('".$_SESSION['login']['id']."', '".$date."');";
  echo $query1;
  
  if(!($resultCart1 = @ mysql_query($query1,$db )))
    showerror();
  echo mysql_insert_id();
  $last_id = mysql_insert_id();

  $query2 = "UPDATE `cart` SET order_id = '".$last_id."' WHERE client_id = '".$_SESSION['login']['id']."' AND order_id IS NULL;";
  if(!($resultCart2 = @ mysql_query($query2,$db )))
    showerror();

  header('Location:../orders.php');
}

else{
  $message2='Faça Login ou Registe-se para fazer compras';
  header('Location:'.$prevloc.'&message2='.$message2);
}
?>
