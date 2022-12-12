<?php


include "../database.php";

$returns=array();

$date1=$_POST["date"];

$result=$connection->query("SELECT HOUR(`visittimestamp`),COUNT(`visits`.uservisitid) FROM `visits`
WHERE (DATE(`visittimestamp`)='$date1' AND HOUR(`visittimestamp`) BETWEEN '0' AND '23')
GROUP BY HOUR(`visittimestamp`) 
ORDER BY HOUR(`visittimestamp`) ASC ");

   if(mysqli_num_rows($result)>0)
  {
	   $return1=array("statusCodeVisits"=>"Success");
	  
	   while($row = $result->fetch_array())
	   {
		   
		                  $visits[] = array(
                                    "visithours" =>$row[0],		   
									"visits" =>  $row[1]
		                    );
		   
		   
	   }
	   
	   $returns = array_merge($return1,$visits);
	  
  }else
   {
	   $returns["statusCodeVisits"]="error1";
	  
   }
  
  	$result=$connection->query("SELECT HOUR(`visittimestamp`) , COUNT(`visits`.uservisitid) FROM `visits` 
	INNER JOIN `mycovid` ON (`visits`.uservisitid=`mycovid`.coviduserid AND DATEDIFF(DATE(`visits`.visittimestamp),`mycovid`.coviddate) BETWEEN 0 AND 14)
	WHERE (DATE(`visittimestamp`)='$date1' ) AND (HOUR(`visittimestamp`) BETWEEN '0' AND '23')
	GROUP BY HOUR(`visittimestamp`) 
    ORDER BY HOUR(`visittimestamp`) ASC ");
	
    if(mysqli_num_rows($result)>0)
  {
	  
	   $return1=array("statusCodeCovid"=>"Success");
	   
	  while($row = $result->fetch_array())
	  {

		 		$covid[]=array(
			
			     "covidhours"=>$row[0],
                 "covid"=>$row[1]				 
			);	  
	  }
	  
	  $returns = array_merge($returns,$return1,$covid);
	  
  }else
  {
	  $returns["statusCodeCovid"]="error1";
  }
  
  echo json_encode($returns);

 mysqli_close($connection);

?>