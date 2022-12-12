<?php

function checkusername($username1)
{
	$username2=preg_match("/^[a-zA-Z0-9]*$/",$username1);
	if(!$username2)
	{
		return false;
	}else
	{
		return true;
	}
}

function checkEmail($email1)
{
	   $email1=filter_var($email1,FILTER_SANITIZE_EMAIL);
	   if(filter_var($email1,FILTER_VALIDATE_EMAIL)==false)
	   {
		   return false;
		   
       }else

	   {
		   return true;
	   }		   
}

function passwordlength($password1)
{
	if(strlen($password1)<8)
	{
		return false;
		
	}else
	{
		return true;
	}
	
}

function passwordformat($password1)
{
	 $number1=preg_match("@[0-9]@", $password1);
	 $uppercase=preg_match("@[A-Z]@", $password1);
	 $specialCharacters=preg_match("@[^\w]@", $password1);
	 	 
    if( !$number1 || !$uppercase || !$specialCharacters)
	{
		
		return false;
				
	}else
	{
		return true;
	}
	

}
?>