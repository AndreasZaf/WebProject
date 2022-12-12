<?php

 include "../database.php";
 
 $returns=array();
 
 $poiid=$_POST["id"];
 
 $currentdate=date("Y-m-d");
 
 $numberofday=date("w", strtotime($currentdate))-1;
 
 date_default_timezone_set("Europe/Athens");
 $currenttime=date("H:i:s");
 
 $help=substr($currenttime,0,2);
 
 if($help<10)
 {
	 $currenttime=substr($currenttime,1,1);
 
 }else
 {
	 $currenttime=substr($currenttime,0,2);
	 
	 if($currenttime==22 || $currenttime==23)
	 {
		 $currenttime=21;
	 }
 }
 
 $onehourindex=$currenttime+1;
 $twohourindex=$currenttime+2;
 
 
 $result=$connection->query(" SELECT JSON_EXTRACT(`populartimes`,'$[$numberofday].data[$onehourindex]') as name1,
 JSON_EXTRACT(`populartimes`,'$[$numberofday].data[$twohourindex]')as name 
 FROM `pois` WHERE poiid='$poiid'");
 
 
  if(mysqli_num_rows($result)>0)
 {
	 $returns["statusCode"]="Success";
	 
	 $sum=0;
	 $counter=0;
	 
	 while($row = $result->fetch_array())
	 {
		 $counter=$counter+2;
		 $sum=$sum+$row[0]+$row[1];
	 }
	 
	 $returns["popularity"]=round($sum/$counter);
	 
 }else
  {
	  $returns["statusCode"]="error1";
  }
 
 $result=$connection->query("SELECT SUM(popularity) AS SUM1,COUNT(DISTINCT(userid)) AS COUNT1 FROM `popularity` 
 WHERE poiid='$poiid' AND HOUR(TIMEDIFF(TIME(NOW()),TIME(date1))) BETWEEN 0 AND 2");
 
 if(mysqli_num_rows($result)>0)
 {
	 $returns["statusCode1"]="Success";
	 
	 $row=$result->fetch_assoc();
	 
	 $returns["averagepopularity"]=round($row["SUM1"]/$row["COUNT1"]);
	 
 }else
  {
	  $returns["statusCode1"]="error1";
  }
 
 $result=$connection->query("SELECT `current_popularity` FROM `pois` WHERE poiid='$poiid'");
 
  if(mysqli_num_rows($result)>0)
 {
	 $returns["statusCode2"]="Success";
	 
	 $row=$result->fetch_assoc();
	 
	 $returns["current_popularity"]=$row["current_popularity"];
	 
 }else
  {
	  $returns["statusCode2"]="error1";
  }
  
  echo json_encode($returns);
 
 mysqli_close($connection);

?>