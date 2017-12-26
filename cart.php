<?php

require_once "HTML/Template/IT.php";
include 'db/db.php';


// ligação à base de dados
$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
if($db) {
  // criar query numa string
  $query  = "SELECT microposts.*, users.name FROM microposts, users WHERE microposts.user_id = users.id";
  
  // executar a query
  if(!($result = @ mysql_query($query,$db )))
   showerror();

  // Cria um novo objecto template
  $template = new HTML_Template_IT('.');

  // Carrega o template Filmes2_TemplateIT.html
  $template->loadTemplatefile('html_templates/cart_template.html', true, true);

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
  // trabalha com o bloco NAV do template
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

  // Faz o parse do bloco NAV
  $template->parseCurrentBlock();

  // ############################################### CART #########################################
  
  if ($loginDone){
    $id = $_SESSION['login']['id'];
    
    $queryCart  = "SELECT cart.product_id,cart.quantity,products.name,products.image,products.price, COUNT(*) AS quantity FROM cart INNER JOIN products
    ON cart.product_id = products.id AND cart.client_id='".$id."' AND cart.order_id IS NULL GROUP BY client_id, product_id;";
    // executar a query
    if(!($resultCart = @ mysql_query($queryCart,$db )))
      showerror();
    
    // mostra o resultado da query utilizando o template
    
    $nrows  = mysql_num_rows($resultCart);
    if($nrows>0){
    $total = 0;
      for($i=0; $i<$nrows; $i++) {
        $tuple = mysql_fetch_array($resultCart,MYSQL_ASSOC);
        // trabalha com o bloco FILMES do template
        $template->setCurrentBlock("ITEM");

        $template->setVariable('ITEM_ID', $tuple['product_id']);
        $template->setVariable('QUANTITY', $tuple['quantity']);
        $template->setVariable('PRICE', $tuple['price']);
        $template->setVariable('NAME', $tuple['name']);
        $template->setVariable('IMAGE', $tuple['image']);
      
        // Faz o parse do bloco FILMES
        $template->parseCurrentBlock();
        $total += $tuple['quantity']*$tuple['price'];
      } // end for
      $template->setCurrentBlock("TOTAL");
      $template->setVariable('TOTAL', $total);
      $template->setVariable('CREATE_ORDER', "utils/createOrder.php");
      $template->parseCurrentBlock();
      $template->parse("CART");
    }else{
      $template->setCurrentBlock("MESSAGE");
      $template->setVariable('MESSAGE', "Your cart is empty. Add items and they will appear here.");
      $template->parseCurrentBlock();
    }
  }else{
    if(isset($_SESSION['basket'])){
      if (!empty($_SESSION['basket'])) {
        // list is empty.
    
        $total = 0;
        foreach ($_SESSION['basket'] as $row) {
          $queryProd  = "SELECT * FROM products WHERE id='".$row["pid"]."';";
          if(!($resultCart = @ mysql_query($queryProd,$db )))
            showerror();
          $resultCart = mysql_fetch_array($resultCart,MYSQL_ASSOC);
          $template->setCurrentBlock("ITEM");
          
          $template->setVariable('ITEM_ID', $resultCart['id']);
          $template->setVariable('QUANTITY', $row['quantity']);
          $template->setVariable('PRICE', $resultCart['price']);
          $template->setVariable('NAME', $resultCart['name']);
          $template->setVariable('IMAGE', $resultCart['image']);
        
          $total += $row['quantity']*$resultCart['price'];
          $template->parseCurrentBlock();
        }
        $template->setCurrentBlock("TOTAL");
        $template->setVariable('TOTAL', $total);
        $template->setVariable('CREATE_ORDER', "login.php");
        $template->parseCurrentBlock();
        $template->parse("CART");
      }else{
        $template->setCurrentBlock("MESSAGE");
        $template->setVariable('MESSAGE', "Your cart is empty. Add items and they will appear here.");
        $template->parseCurrentBlock();
      }
    }
  }
  

  // ############################################### CART #########################################

  // Mostra a tabela
  $template->show();

  // fechar a ligação à base de dados
  mysql_close($db);
} // end if 
?>