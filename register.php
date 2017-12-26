<?php

require_once "HTML/Template/IT.php";

  // Cria um novo objecto template
  $template = new HTML_Template_IT('.');

  // Carrega o template Filmes2_TemplateIT.html
  $template->loadTemplatefile('html_templates/register_template.html', true, true);


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


  // Faz o parse do bloco NAV
  $template->parseCurrentBlock();

  $name = "";
  $email = "";
  if (isset($_GET['message'])) {
    $name = $_GET['name'];
    $email = $_GET['email'];
    $message = $_GET['message'];
  }

  $template->setCurrentBlock("ERROR");
  $template->setVariable('MESSAGE', $message);
  $template->parseCurrentBlock();

  $template->setCurrentBlock("FORM");
  $template->setVariable('NAME', $name);
  $template->setVariable('EMAIL', $email);
  $template->parseCurrentBlock();


  // Mostra a tabela
  $template->show();
?>