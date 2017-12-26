<?php

require_once "HTML/Template/IT.php";
include 'db/db.php';


$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
if($db) {

  $query  = "SELECT microposts.*, users.name FROM microposts, users WHERE microposts.user_id = users.id";
  
  if(!($result = @ mysql_query($query,$db )))
   showerror();

  $template = new HTML_Template_IT('.');

  $template->loadTemplatefile('html_templates/orders_template.html', true, true);

  $loginDone = false;

  session_start();

  if(isset($_COOKIE["rememberMe"])) {
      $query2 ="SELECT id, name FROM users WHERE remember_digest='".$_COOKIE["rememberMe"]."';";

      if($result2 = @ mysql_query($query2,$db )){
        $row = mysql_fetch_assoc($result2);
        $loginDone = true;
        $name = $row['name'];
        $id = $row['id'];
      }
  }else if(isset($_SESSION['login'])){
    $loginDone = true;
    $name = $_SESSION['login']['name'];
    $id = $_SESSION['login']['id'];
  }

  $template->setCurrentBlock("NAV");
  if ($loginDone){
    $template->setVariable('url1', "index.php");
    $template->setVariable('url2', "orders.php");
    $template->setVariable('url_cart', "cart.php");
    $template->setVariable('url3', "utils/logout_action.php");
    $template->setVariable('CART', "Cart");
    $template->setVariable('MENU_1', "Home");
    $template->setVariable('MENU_2', "Orders");
    $template->setVariable('MENU_3', "Logout");
    $template->setVariable('WELCOME', "Welcome ".$name);
  }else{
    header('Location:'."index.php");
    $template->setVariable('url1', "index.php");
    $template->setVariable('url_cart', "cart.php");
    $template->setVariable('url2', "login.php");
    $template->setVariable('url3', "register.php");
    $template->setVariable('CART', "Cart");
    $template->setVariable('MENU_1', "Home");
    $template->setVariable('MENU_2', "Login");
    $template->setVariable('MENU_3', "Register");
  }

  // Faz o parse do bloco NAV
  $template->parseCurrentBlock();

  // ############################################### CART #########################################
  
  if ($loginDone){
    $id = $_SESSION['login']['id'];
  }
  $queryCarts = "SELECT * FROM orders WHERE customer_id='".$id."';";

  if(!($resultCarts = @ mysql_query($queryCarts,$db )))
    showerror();
  $ncarts  = mysql_num_rows($resultCarts);
  
  if($ncarts > 0){
    for($j=0; $j<$ncarts; $j++) {
      //$template->setCurrentBlock("CART");
      $tupleCart = mysql_fetch_array($resultCarts,MYSQL_ASSOC);
      $queryCart  = "SELECT cart.product_id,cart.quantity,products.name,products.image,products.price, COUNT(*) AS quantity FROM cart INNER JOIN products
      ON cart.product_id = products.id AND cart.client_id='".$id."'  AND cart.order_id= '".$tupleCart['id']."' GROUP BY client_id, product_id;";
      
      if(!($resultCart = @ mysql_query($queryCart,$db )))
        showerror();
      
      
      $template->setCurrentBlock("HEADER");
      $template->setVariable('ORDER_NUMBER', ($j+1));
      $template->setVariable('ORDER_DATE', $tupleCart['created_at']);
      $template->parseCurrentBlock();
      $nrows  = mysql_num_rows($resultCart);
      $total = 0;
        for($i=0; $i<$nrows; $i++) {
          $tuple = mysql_fetch_array($resultCart,MYSQL_ASSOC);

          $template->setCurrentBlock("ITEM");

          $template->setVariable('ITEM_ID', $tuple['product_id']);
          $template->setVariable('QUANTITY', $tuple['quantity']);
          $template->setVariable('PRICE', $tuple['price']);
          $template->setVariable('NAME', $tuple['name']);
          $template->setVariable('IMAGE', $tuple['image']);
        
          $template->parseCurrentBlock();
          $total += $tuple['quantity']*$tuple['price'];
        } 
        $template->setCurrentBlock("TOTAL");
        $template->setVariable('TOTAL', $total);
        $template->parseCurrentBlock();
      $template->parse("CART");
    }
  }else{
    $template->setCurrentBlock("MESSAGE");
    $template->setVariable('MESSAGE', "Create an order and it will appear here.");
    $template->parseCurrentBlock();
  }
  // ############################################### CART #########################################

  $template->show();

  mysql_close($db);
}
?>