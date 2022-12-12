<?php

   session_start();
   
   include "../database.php";
   
   $returns=array();
   
   $userid=$_SESSION["email"];
   	   
    $result=$connection->query("SELECT `visittimestamp`,`spenttime` FROM `visits` WHERE uservisitid = '$userid' ORDER BY visittimestamp ASC");
       
   if(mysqli_num_rows($result)>0)
   {
	   $return1=array("statusCodeVisits"=>"Success");
	   
	   while($row = $result->fetch_array())
	   {               
                             $information[] =array(
							                                 "visittimestamp" => $row[0],
															 "spenttime" =>  $row[1]
															 
															 
															 );
	       				 					 						 	 
	   }
	   
	   $returns=array_merge($return1,$information);
   }else
   {
	   $returns["statusCodeVisits"]="error1";
   }
   
   $result=$connection->query("SELECT `coviddate` FROM `mycovid` WHERE  `coviduserid`= '$userid'");
         
   if(mysqli_num_rows($result)>0)
   {
	   $return1=array("statusCodeCovid"=>"Success");
	   
	   while($row = $result->fetch_array())
	   {
		              $information[] = array(
				                              "coviddate" =>$row[0]
											  );
											  
											  
	   }
	   
	   $returns2=array_merge($return1,$information);
	   
	   $returns=$returns+$returns2;
	   
   }else
   {
	   $returns["statusCodeCovid"]="error1";
   }
   
   echo json_encode($returns);
   
   mysqli_close($connection);
   
?>