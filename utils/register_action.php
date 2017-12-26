<?php
include('../db/db.php');

if (isset($_POST['name']))
{
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $passwordR = $_POST['passwordR'];

  if ($password!=$passwordR)
  {
    $message =" As passwords não correspondem.";
    header("location: ../register.php?message=".$message."&name=".$name."&email=".$email);
  }else{
    $db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
    if($db) {
    $date = date("Y-m-d H:i:s");
    $hashpass = substr(md5($password),0,32);
    $query = "INSERT INTO customers (name, email, created_at, updated_at, password_digest) VALUES ('".$name."', '".$email."', '".$date."', '".$date."', '".$hashpass."');";
    
    if($result = @ mysql_query($query,$db ))
      header("location: ../html_templates/register_success.html");
    else{
      $err = mysql_error();
      if(substr($err, 0, 9)=='Duplicate') {
        $message = "Email ja existe!";
        header("location: ../register.php?message=".$message."&name=".$name."&email=".$email);
      }
      else
        header("location: ../register.php?message=".$err."&name=".$name."&email=".$email);
    }
    
      // fechar a ligação à base de dados
      mysql_close($db);
    } // end if 
  }
}else
  header("location: ../register.php");


?>
