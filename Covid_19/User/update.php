<?php

   session_start();
   
   include "../database.php";
   include "../phpfunctions.php";
     
   $returns=array();
   
   $newusername1=$_POST["newusername"];
   $newpassword1=$_POST["newpassword"];
   $email1=$_SESSION["email"];
            
   $passwordsame=false;
   $usernamesame=false;
      
	if($_SESSION["username"]!=$newusername1)
	{
		if(checkusername($newusername1)==false)
	    {
				$returns["statusCode"]="error2";
		        $returns["message"]="invalid username";
				echo json_encode($returns);
				exit();
	    }
		
	}else
	{
			   $usernamesame=true;
	}
		   	   
	if($_SESSION["password"]!=$newpassword1)
	{			 
	     if(passwordlength($newpassword1)==false)
	     {
			   $returns["statusCode"]="error2";
		       $returns["message"]="Password must be at least 8 characters";
			   echo json_encode($returns);
			   exit();
			   
	     }else
	     {
		      if(passwordformat($newpassword1)==false)
		     {
				$returns["statusCode"]="error2";
			    $returns["message"]="Password must be contain at least one number, one upper case letter and one special character.";
				echo json_encode($returns);
				exit();
		     }
	     }
    }else
	{
			 $passwordsame=true;
	}
	
	if($usernamesame==false  && $passwordsame==false)
	{
		$result=$connection->query("SELECT `username` FROM `users` WHERE username='$newusername1'");		
		if(mysqli_num_rows($result)>0)
	   {
		   		$returns["statusCode"]="error2";
				$returns["message"]="Username is already exists";
		        echo json_encode($returns);
				exit();
	   }else
	   {
		   $update_data="UPDATE users SET username='$newusername1',password='$newpassword1' WHERE email='$email1'";
	   }
		
		
	}elseif($usernamesame==false  && $passwordsame==true)
	{
		
	  $result=$connection->query("SELECT `username` FROM `users` WHERE username='$newusername1'");
	   
	   if(mysqli_num_rows($result)>0)
	   {
		   		$returns["statusCode"]="error2";
				$returns["message"]="Username is already exists";
		        echo json_encode($returns);
				exit();
	   }else
	   {
		   $update_data="UPDATE users SET username='$newusername1' WHERE email='$email1'";
	   }
			
			
	}elseif($usernamesame==true && $passwordsame==false)
	{
		$update_data="UPDATE users SET password='$newpassword1' WHERE email='$email1'";
		
	}elseif($usernamesame==true && $passwordsame==true)
	{
		
			$returns["statusCode"]="error1";
		    echo json_encode($returns);
		    exit();
	}
	
	if($connection->query($update_data)==true)
    {
			       $returns["statusCode"]="Success";
				   $returns["message"]="Succesful update data"; 
				   $_SESSION["username"]=$newusername1;
				   $_SESSION["password"]=$newpassword1;
				   $returns["username"]=$newusername1;
			       echo json_encode($returns);
			   
    }else
    {
			       $returns["statusCode"]="error3";
			       $returns["message"]="Cannot update data";
			       echo json_encode($returns);
    }
	
	unset($returns);
?>