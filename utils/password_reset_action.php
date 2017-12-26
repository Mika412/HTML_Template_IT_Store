<?php
include('db.php');
include('utils/sendmail.php');

if(isset($_POST['email'])){
    $db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
    if($db) {

        $email = $_POST['email'];
        $query ="SELECT id, name, email FROM users WHERE email='".$email."';";
        $result = @ mysql_query($query,$db );
        
        if(mysql_num_rows($result) === 0){
            header("location: password_reset.php?error=1");
        }else{
            $row = mysql_fetch_assoc($result);

            $date = date("Y-m-d H:i:s");
            $reset_digest = substr(md5(time()),0,32); 
            
            $query2 = "UPDATE users  SET reset_digest='".$reset_digest."', reset_sent_at='".$date."' WHERE email='".$email."';";
            if($result2 = @ mysql_query($query2,$db )){
                mailResetPassword($row['name'],$row['email'],$reset_digest);
                header("location: message.php?code=1");
            }
        }
      // fechar a ligação à base de dados
      mysql_close($db);
    }
}else
    header("location: password_reset.php");


?>
