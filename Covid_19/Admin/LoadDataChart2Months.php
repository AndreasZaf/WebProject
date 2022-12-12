<?php

include "../database.php";

   $returns=array();

  $yearmonth=$_POST["Year_Month"];
  
  $year=substr($yearmonth,0,4);
  
  $month=substr($yearmonth,5,7);
  
  
  $result=$connection->query("SELECT DATE(`visittimestamp`),COUNT(`visits`.uservisitid) FROM `visits`
  WHERE(MONTH(`visittimestamp`)='$month' AND YEAR(`visittimestamp`)='$year') 
  GROUP BY DATE(`visittimestamp`)");
  
   if(mysqli_num_rows($result)>0)
  {
	   $return1=array("statusCodeVisits"=>"Success");
	   
	   while($row = $result->fetch_array())
	   {
		                  $visits[] = array(
                                    "visitsday" =>$row[0],
                                    "visits" =>  $row[1]
                                 );
	   }
	   
	   $returns = array_merge($return1,$visits);
	  
  }else
  {
	  $returns["statusCodeVisits"]="error1";
  }
  
   $result=$connection->query("SELECT DATE(`visittimestamp`),COUNT(`visits`.uservisitid) FROM `visits`
   INNER JOIN `mycovid` ON (`visits`.uservisitid=`mycovid`.coviduserid AND DATEDIFF(DATE(`visits`.visittimestamp),`mycovid`.coviddate) BETWEEN 0 AND 14 )
   WHERE(MONTH(`visittimestamp`)='$month' AND YEAR(`visittimestamp`)='$year') 
   GROUP BY DATE(`visittimestamp`)"); 
   
   if(mysqli_num_rows($result)>0)
  {
	  $return1=array("statusCodeCovid"=>"Success");
	  
	  while($row = $result->fetch_array())
	  {
	      
		  	$covid[]=array(
			
			     "covidday"=>$row[0],
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