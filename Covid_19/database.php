<?php

  $servername="localhost";
  $username="root";
  $password="a1a2a3a4a5";
  $database1="covid19";
  $connection=new mysqli($servername,$username,$password,$database1);
  
  if($connection->connect_error)
  {
	  die("Connection failed".$connection->connect_error);
  }
  
?>