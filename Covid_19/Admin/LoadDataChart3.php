<?php

 include "../database.php";
 
 $returns=array();
 
 $result=$connection->query("SELECT pois.types as visittypes, COUNT(`visits`.visitpoiid) AS visits
 FROM `pois` INNER JOIN `visits` ON `pois`.poiid = `visits`.visitpoiid
 GROUP BY `pois`.types
 ORDER BY visits DESC");
  
  
   if(mysqli_num_rows($result)>0)
   {
	   $return1=array("statusCodeVisits"=>"Success");
	      
	      while($row = $result->fetch_array())
		  {
			                 $typesvisit[] = array(
							   
							    "visittypes"=> $row[0],
								"visits"=> $row[1]
                                 );
		  }
		  
		  $returns=array_merge($return1,$typesvisit);
			  
   }else
	{
		$returns["statusCodeVisits"]="error1";
	}
   
  
 
     $result=$connection->query("SELECT `pois`.types as covidtypes, COUNT(`visits`.visitpoiid) AS covid
      FROM `pois` INNER JOIN `visits` ON (`pois`.poiid = `visits`.visitpoiid) 
	  INNER JOIN `mycovid` ON(`visits`.uservisitid=`mycovid`.coviduserid)
      WHERE ((DATEDIFF(`mycovid`.coviddate,DATE(`visits`.visittimestamp)) BETWEEN 0 AND 7) OR (DATEDIFF(DATE(`visits`.visittimestamp),`mycovid`.coviddate) BETWEEN 1 AND 14))
      GROUP BY `pois`.types	  
	  ORDER BY covid DESC");
	   
  if(mysqli_num_rows($result)>0)
 {
	 $return1=array("statusCodeCovid"=>"Success");
	 
	  while($row = $result->fetch_array())
	  {
		  	  
              			     $typescovid[] = array(
							   
							    "covidtypes"=> $row[0],
								"covid"=> $row[1]
                                 );
		  
	  }
	  
      $returns=array_merge($returns,$return1,$typescovid);
	  
 }else
 {
	 $returns["statusCodeCovid"]="error1";
 }	 


  echo json_encode($returns);
 
 
  mysqli_close($connection);


?>