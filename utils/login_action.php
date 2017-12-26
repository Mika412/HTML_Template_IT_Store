<?php
	include('../db/db.php');
	if(isset($_POST['email'])){
		$db = dbconnect($hostname,$db_name,$db_user,$db_passwd); 
		$email = $_POST['email'];
		$pwd = $_POST['password'];
		$hashpwd = substr(md5($pwd),0,32);
		$query ="SELECT id, name FROM customers WHERE email='".$email."' AND password_digest ='".$hashpwd."';";

		$result = @ mysql_query($query,$db );

		if(mysql_num_rows($result) === 0){
			header("location: ../login.php?error=1");
		}else{
			$row = mysql_fetch_assoc($result);

			
			if(isset($_POST['autologin'])){
				$cookie_name = "rememberMe";
				$cookie_value = substr(md5(time()),0,32);
				setcookie($cookie_name, $cookie_value, time() + (3600 * 24 * 30), "/");

				$query2 = "UPDATE users  SET remember_digest='".$cookie_value."' WHERE id='".$row['id']."';";
				if($result2 = @ mysql_query($query2,$db )){
					echo "workds";
				}
			}


			session_start();
			$_SESSION['login']=$row;

			if(isset($_SESSION['basket'])){
				foreach ($_SESSION['basket'] as $ppp) {
					@ mysql_query("INSERT INTO `cart` (`client_id`, `product_id`, `quantity`) VALUES ('".$row['id']."', '".$ppp["pid"]."',  '".$ppp["quantity"]."') ON DUPLICATE KEY UPDATE quantity = quantity+1;",$db );
				}
				unset($_SESSION['basket']);
			}
			header("location: ../index.php");
		}
	}else
		header("location: ../login.php");
?>
