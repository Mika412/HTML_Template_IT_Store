
<?php

require_once "HTML/Template/IT.php";

  $template = new HTML_Template_IT('.');

  $template->loadTemplatefile('../html_templates/message_template.html', true, true);



    if (isset($_COOKIE['rememberMe'])) {
      unset($_COOKIE['rememberMe']);
      setcookie('rememberMe', '', time() - 3600, '/'); // empty value and old timestamp
    }
    session_start();
    session_destroy();
    $template->setCurrentBlock("MESSAGE");
    $template->setVariable('MESSAGE', "See you soon!");
    $template->parseCurrentBlock();


    $template->show();
?>