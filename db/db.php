<?php
// mostra uma mensagem de erro vinda do mysql
function showerror()
{
 die("Error " . mysql_errno() . " : " . mysql_error());
}
$hostname = "localhost";
$db_name = "db_store";
$db_user = "root";
$db_passwd = "";
// faz uma conexão a uma base de dados
function dbconnect($hostname,
$db_name,$db_user,$db_passwd)
{
 $db = @ mysql_connect($hostname, $db_user,$db_passwd);
 if(!$db) {
 die("Cant connect to database.");
 }
 if(!(@ mysql_select_db($db_name,$db))){
 showerror();
 }
 return $db;
}
?>
