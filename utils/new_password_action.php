<?php
include('db.php');

if(isset($_POST['token'])){
    $db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
    if($db) {
        $token = $_POST['token'];
        $query ="SELECT id, reset_sent_at FROM users WHERE reset_digest='".$token."';";
        $result = @ mysql_query($query,$db);
        
        if(mysql_num_rows($result) === 0){
            header("location: message.php?code=3");
        }else{
            $row = mysql_fetch_assoc($result);

            $date = date("Y-m-d H:i:s");
            
            $datetime1 = strtotime($date);
            $datetime2 = strtotime($row['reset_sent_at']);
            
            $secs = $datetime1 - $datetime2;// == <seconds between the two times>
            $hours = $secs / 3600;
            if($hours > 1){
                header("location: message.php?code=3");
            }else{
                $hashpass = substr(md5($_POST['password']),0,32);
                $query2 = "UPDATE users  SET password_digest='".$hashpass."', reset_digest='' WHERE id='".$row['id']."';";
                if($result2 = @ mysql_query($query2,$db )){
                    header("location: message.php?code=2");
                }
            }
        }
      // fechar a ligação à base de dados
      mysql_close($db);
    }
}else
    header("location: password_reset.php");


?>
