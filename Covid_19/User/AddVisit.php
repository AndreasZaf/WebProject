<?php

   session_start();
   
   include "../database.php";
   
   $email = $_SESSION["email"];
   $poiid = $_POST["id"];
   
   $spenttime=(int)$_POST["spenttime"];
   
   $current_popularity=(int)$_POST["current_popularity"];
   
   $connection -> autocommit(FALSE);
  
   $connection-> query("INSERT INTO `visits`(`uservisitid`,`visitpoiid`,`visittimestamp`,`spenttime`) VALUES ('$email','$poiid',NOW(),'$spenttime')");
   
   $connection->query("UPDATE pois SET current_popularity='$current_popularity' WHERE poiid='$poiid'");
   
   $connection->query("INSERT INTO `popularity`(`poiid1`,`userid1`,`date1`,`popularity`) VALUES('$poiid','$email',NOW(),'$current_popularity')");
   
   if ($connection -> commit()==true)
   {
	   $returns["statusCode"]="Success";
	   $returns["message"]="Succesful Add Visit";
	   echo json_encode($returns);
	
   }else
   {
	   		$returns["statusCode"]="error1";
			$returns["message"]="Unsuccesful Add Visit";
			echo json_encode($returns);
   }
      
   mysqli_close($connection);

?>