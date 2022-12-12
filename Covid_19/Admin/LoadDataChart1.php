<?php

include "../database.php";

$returns=array();

 $result=$connection->query("SELECT COUNT(*) As totalvisits FROM `visits`");
 
 if(mysqli_num_rows($result)>0)
 { 
     
	  $row=$result->fetch_assoc();
	 
	  $returns["totalvisits"]=$row["totalvisits"];
 }else
 {
	 $returns["totalvisits"]=0;
 }
 
 
 $result=$connection->query("SELECT COUNT(*) As totalcovid FROM `mycovid`");
 
  if(mysqli_num_rows($result)>0)
 { 
     
	  $row=$result->fetch_assoc();
	 
	  $returns["totalcovid"]=$row["totalcovid"];
 }else
 {
	 $returns["totalcovid"]=0;
 }
 
  $result=$connection->query("SELECT COUNT(*) AS count1 FROM `visits` INNER JOIN `mycovid` ON(`visits`.uservisitid=`mycovid`.coviduserid) 
   WHERE((DATEDIFF(`mycovid`.coviddate,DATE(`visittimestamp`)) BETWEEN 0 AND 7) OR (DATEDIFF(`mycovid`.coviddate,DATE(`visittimestamp`)) BETWEEN 1 AND 14))");
  
  if(mysqli_num_rows($result)>0)
 { 

      $row=$result->fetch_assoc();
	 
	  $returns["visitcovid"]=$row["count1"];
	  
 }else
 {
	 $returns["visitcovid"]=0;
 }
 
 echo json_encode($returns);
 
 
 mysqli_close($connection);

?>