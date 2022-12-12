<?php

include "../database.php";


  $returns=array();

  $date1=$_POST["date"];
  
  $result=$connection->query("SELECT DATE(`visittimestamp`),COUNT(`visits`.uservisitid) FROM `visits`
  WHERE ( DATE(`visittimestamp`)='$date1' OR DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +1 day) OR DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +2 day) OR
  DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +3 day) OR DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +4 day) OR 
  DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +5 day) OR DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +6 day))
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
  
  $result=$connection->query("SELECT DATE(`visittimestamp`) ,COUNT(*)  FROM `visits` 
  INNER JOIN `mycovid` ON(`visits`.uservisitid=`mycovid`.coviduserid AND DATEDIFF(DATE(`visits`.visittimestamp),`mycovid`.coviddate) BETWEEN 0 AND 14)
  WHERE ( DATE(`visittimestamp`)='$date1' OR DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +1 day) OR DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +2 day) OR
  DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +3 day) OR DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +4 day) OR 
  DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +5 day) OR DATE(`visittimestamp`)= DATE_ADD('$date1',INTERVAL +6 day))
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