<?php

require_once "HTML/Template/IT.php";

  $template = new HTML_Template_IT('.');

  $template->loadTemplatefile('html_templates/message_template.html', true, true);


  $template->setCurrentBlock("MESSAGE");
  $code = $_GET['code'];
  if ($code == "1") {
    $template->setVariable('MESSAGE', "Password reset activated! <br> Email sent to you :-)");
  }else if($code == "2"){
    $template->setVariable('MESSAGE', "Password reset successfully! ");
  }else if($code == "3"){
    $template->setVariable('MESSAGE', "ERROR: WRONG TOKEN OR TOKEN EXPIRED, PASSWORD RESET FAILED!");
  }

  $template->parseCurrentBlock();

  // Mostra a tabela
  $template->show();
?>