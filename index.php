<?php

require_once "HTML/Template/IT.php";
include 'db/db.php';

$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
if($db) {
  $query  = "SELECT microposts.*, users.name FROM microposts, users WHERE microposts.user_id = users.id";
  
  if(!($result = @ mysql_query($query,$db )))
   showerror();

  $template = new HTML_Template_IT('.');

  $template->loadTemplatefile('html_templates/index_template.html', true, true);

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
    $template->setVariable('url1', "index.php");
    $template->setVariable('url_cart', "cart.php");
    $template->setVariable('url2', "login.php");
    $template->setVariable('url3', "register.php");
    $template->setVariable('CART', "Cart");
    $template->setVariable('MENU_1', "Home");
    $template->setVariable('MENU_2', "Login");
    $template->setVariable('MENU_3', "Register");
  }

  $template->parseCurrentBlock();

  // ############################################### CATEGORIES #########################################
  $queryCategories  = "SELECT * FROM categories";

  // executar a query
  if(!($resultCategories = @ mysql_query($queryCategories,$db )))
    showerror();

  //////////////////Show All button
    $template->setCurrentBlock("CATEGORIES");
  
    $template->setVariable('LINK', "index.php");
    $template->setVariable('CATEGORY', "ALL");
  
    $template->parseCurrentBlock();

  ////////////////////////
  $nrows  = mysql_num_rows($resultCategories);
    for($i=0; $i<$nrows; $i++) {
      $tuple = mysql_fetch_array($resultCategories,MYSQL_ASSOC);
      $template->setCurrentBlock("CATEGORIES");

      $template->setVariable('LINK', "index.php?cat=".$tuple['name']);
      $template->setVariable('CATEGORY', $tuple['name']);
    
      $template->parseCurrentBlock();

    } // end for
  
  
  // ############################################### CATEGORIES #########################################

  // ############################################### PRODUCTS #########################################
  if (isset($_GET['cat'])){
    $cat=$_GET['cat'];
    $queryCheckCategory  = "SELECT * FROM categories WHERE name ='".$cat."';";
    if(!($resultCategory = @ mysql_query($queryCheckCategory,$db )))
      showerror();
      
    if(mysql_num_rows($resultCategory) > 0){
      $tupple = mysql_fetch_array($resultCategory,MYSQL_ASSOC);
      $queryAllProducts  = "SELECT * FROM products WHERE cat_id='".$tupple['id']."';";
    }else
      $queryAllProducts  = "SELECT * FROM products";
  }else{
    $queryAllProducts  = "SELECT * FROM products";
  }

  if(!($resultProducts = @ mysql_query($queryAllProducts,$db )))
    showerror();

  $elements_per_row = 3; //should be done programmatically
  $nrows  = mysql_num_rows($resultProducts);
    for($i=0; $i<$nrows; $i++) {
      $tuple = mysql_fetch_array($resultProducts,MYSQL_ASSOC);
      $template->setCurrentBlock("PRODUCT");
      if($i % $elements_per_row == 0){
        $template->setVariable('BLOCK1', "<div class=\"card-deck\">");
      }
      $template->setVariable('ACTION_PRODUCT_ADD', "utils/addToCart.php");
      $template->setVariable('PRODUCT_ID', $tuple['id']);
      $template->setVariable('IMAGE_URL', $tuple['image']);
      $template->setVariable('CARD_TITLE', $tuple['name']);
      $template->setVariable('PRICE', $tuple['price']);

      if(($i+1) % $elements_per_row == 0 || ($i+1) == $nrows){
        $template->setVariable('BLOCK2', "</div>");
      }
      $template->parseCurrentBlock();

    } 
 

  // ############################################### PRODUCTS #########################################

  $template->show();

  mysql_close($db);
}
?>