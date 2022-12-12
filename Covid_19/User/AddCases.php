<?php

   session_start();
   
   include "../database.php";
   
   $date1=$_POST["date"];
   $email=$_SESSION["email"];
   
   $returns=array();
   
   date_default_timezone_set("Europe/Athens");
   
   $date = date("Y-m-d");
   
   if($date1>$date)
   {
	  		$returns["statusCode"]="error1";
			$returns["message"]="Date is over from current date";
		   	echo json_encode($returns);
	        exit(); 
   }
	   
   $insert_data="";
   
   $result=$connection->query("SELECT `coviddate` from `mycovid` WHERE coviduserid='$email' 
   ORDER BY `coviddate` DESC LIMIT 1");
   	
   if(mysqli_num_rows($result)>0)
   {
	   $row=$result->fetch_assoc();
	   
	   if(strtotime($date1)<strtotime($row["coviddate"]))
	   {
		   	   $returns["statusCode"]="error1";
			   $returns["message"]="Date is before from last covid date ";
		   	   echo json_encode($returns);
	           exit();
		   
	   }
	   
	   if(strtotime($date1) - strtotime($row["coviddate"])>(14*24*60*60))  
	   {

		   $insert_data= "INSERT INTO `mycovid`(`coviddate`,`coviduserid`) VALUES('$date1','$email')";
	   }else
	   {
		   	   $returns["statusCode"]="error1";
			   $returns["message"]="Date is not over 14 days before covid infection";
		   	   echo json_encode($returns);
	           exit();
	   }
	   
	     
   }else
   {
	  
	    $insert_data= "INSERT INTO `mycovid`(`coviddate`,`coviduserid`) VALUES('$date1','$email')";
	   
   }
	   
   	   
	if($connection->query($insert_data)==true)
	{
			   $returns["statusCode"]="Success";
			   $returns["message"]="Success";
			   echo json_encode($returns);
			   
	}else
	{
			   $returns["statusCode"]="error1";
			   $returns["message"]="Unsuccess";
			   echo json_encode($returns);
	}
	
	   mysqli_close($connection);

?>