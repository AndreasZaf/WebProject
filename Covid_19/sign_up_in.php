<?php
    
   session_start();
   
   include "database.php";
   include "phpfunctions.php";
	
   $returns=array();
   
   if($_POST["type"]==1)
   {
	   $usernameOk=true;
	   $passwordOk=true;
	   $emailOk=true;
	   $username1=$_POST["username"];
	   $email1=$_POST["email"];
	   $password1=$_POST["password"];
	   
	   if(checkusername($username1)==false)
	   {
		   $usernameOk=false;
		   $returns["username"]="invalid username";
	   }
	   
	   
	   if(passwordlength($password1)==false)
	   {
		   $passwordOk=false;
		   $returns["password"]="Password must be at least 8 characters";
	   }else
	   {
		   if(passwordformat($password1)==false)
		   {
			  $passwordOk=false;
			  $returns["password"]="Password must be contain at least one number, one upper case letter and one special character.";
		   }
	   }
	   
	   if(checkEmail($email1)==false)
	   {
		   $emailOk=false;
		   $returns["email"]="Email not a valid email address";
		   
	   }
	   
      if($passwordOk==true && $emailOk==true && $usernameOk==true)
	  {	  
       $name=false;
	   $email=false;
	   
	   $result=$connection->query("SELECT * FROM `users` WHERE username='$username1'");
	   
	   if(mysqli_num_rows($result)>0)
	   {
		   $name=true;
		  $returns["username"]="Username is already exists"; 
	   }
	   
	   $result=$connection->query("SELECT * FROM `users` WHERE email='$email1'");
	   
	   if(mysqli_num_rows($result)>0)
	   {
		   $email=true;
		   $returns["email"]="Email is already exists";
		   
	   }
	   
       if($name==true || $email==true)
	   {
		   $returns["statusCode"]="error1";
		     		   
		   echo json_encode($returns);
		   
	   }else
	   {
		   $insert_data="INSERT INTO `users`(`username`,`email`,`password`,`is_admin`)VALUES('$username1','$email1','$password1','0')";
		   
		   if($connection->query($insert_data)==true)
		   {
			   $returns["statusCode"]="Success";
			   $returns["url"]="signin.html";
			   echo json_encode($returns);
			   
		   }else
		   {
			   $returns["statusCode"]="error3";
			   $returns["message"]="Cannot create account";
			   echo json_encode($returns);
		   }
			   
	   }
	   
	  }else
	  {
		  $returns["statusCode"]="error2";
		  echo json_encode($returns);
	  }
	  
	  
	  mysqli_close($connection);
	   
   }
   
   if($_POST["type"]==2)
   {
	   $username1=$_POST["username"];
	   $password1=$_POST["password"];
	   
	   $width=$_POST["width"];
	   
	   $result=$connection->query("SELECT * from `users` WHERE username='$username1' AND password='$password1'");
	   
	   if(mysqli_num_rows($result)>0)
	   {
		   
		   $row=$result->fetch_assoc();
		   
		   $returns["statusCode"]="Success";
		   
		   if($row["is_admin"]==0)
		   {
			   $returns["url"]="../User/client_dashboard.php";
			   $_SESSION["TypeOfUser"]="User";
			   $_SESSION["username"]=$row["username"];
		       $_SESSION["email"]=$row["email"];
		       $_SESSION["password"]=$row["password"];
			   
		   }else if($row["is_admin"]==1)
		   {
			   if($width<1200)
			   {
				   $returns["statusCode"]="error5";
		           $returns["message"]="Access Denied";
				   echo json_encode($returns);
				   exit();
			   }
			   
			   $returns["url"]="../Admin/admin_dashboard.php";
			   $_SESSION["TypeOfUser"]="Admin";
			   $_SESSION["username"]=$row["username"];
		       $_SESSION["email"]=$row["email"];
		       $_SESSION["password"]=$row["password"];
		   }
		   
		   
		   $_SESSION["login"]="yes";

		   
		   echo json_encode($returns);
	   }else
	   {
		  
		   $returns["statusCode"]="error4";
		   $returns["message"]="User is not exist";
		   
		   echo json_encode($returns);
	   }
	   
	  
	   mysqli_close($connection);
   }
   
?>