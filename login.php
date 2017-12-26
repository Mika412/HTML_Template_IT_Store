<?php

require_once "HTML/Template/IT.php";

  $template = new HTML_Template_IT('.');

  $template->loadTemplatefile('html_templates/login_template.html', true, true);


  $url1 = "index.php";
  $url2 = "login.php";
  $url3 = "register.php";
  
  $template->setCurrentBlock("NAV");

  $template->setVariable('url1', $url1);
  $template->setVariable('url2', $url2);
  $template->setVariable('url3', $url3);
  $template->setVariable('url_cart', "cart.php");
  $template->setVariable('CART', "Cart");
  $template->setVariable('MENU_1', "Home");
  $template->setVariable('MENU_2', "Login");
  $template->setVariable('MENU_3', "Register");


  $template->parseCurrentBlock();

  if (isset($_GET['error'])) {
    $message = "Wrong email or password.";
  }

  $template->setCurrentBlock("ERROR");
  $template->setVariable('MESSAGE', $message);
  $template->parseCurrentBlock();


  $template->show();
?>