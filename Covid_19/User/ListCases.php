<?php

   session_start();
   
   include "../database.php";
   
   $returns=array();

   $email = $_SESSION["email"];
   
   $currentdate=Date("Y-m-d");
		
	$result=$connection->query("SELECT `pois`.poiname,`pois`.poiaddress,`visits`.visittimestamp
        FROM visits 
        INNER JOIN `pois` ON (`visits`.visitpoiid=`pois`.poiid )
		INNER JOIN `mycovid` ON(`visits`.uservisitid=`mycovid`.coviduserid AND (DATEDIFF(DATE(`visits`.visittimestamp),`mycovid`.coviddate)) BETWEEN 0 AND 7
        AND(HOUR(TIMEDIFF(TIME(visittimestamp IN (select visittimestamp FROM `visits` WHERE uservisitid='$email')),TIME(visits.visittimestamp)))BETWEEN -2 AND 2))		
	    WHERE `visits`.uservisitid='$email' AND (DATEDIFF('$currentdate',DATE(`visits`.visittimestamp)) BETWEEN 0 AND 7) 
		ORDER BY DATE(`visits`.visittimestamp) ASC , TIME(`visits`.visittimestamp) ASC");
		
	if(mysqli_num_rows($result)>0)
	{
		   $returns1=array("statusCode"=>"success");
				 
		   while($row = $result->fetch_array())
		   {
			   
			        $information[] = array(
                                    "name" =>  $row[0],
                                    "address" => $row[1],
                                    "timedate" => $row[2]
                                 );
		   }
		   
		   
		   $returns = array_merge($returns1,$information);
	}else
	{
		$returns["statusCode"]="error1";
	}
	
	echo json_encode($returns);
		
	mysqli_close($connection);

?>