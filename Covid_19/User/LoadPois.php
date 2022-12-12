<?php

   include "../database.php";
   $returns=array();
   $input=$_POST["input"];
   $radius=$_POST["radius"];
   $lat1=$_POST["lat"];
   $lng1=$_POST["lng"];
   
   
  $currentdate=date("Y-m-d");
 
 $numberofday=date("w", strtotime($currentdate));
 
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
 
    
   $result=$connection->query("SELECT `poiid`,`poiname`,`poiaddress`,`lat`,`lng`,`current_popularity`,JSON_EXTRACT(`populartimes`,'$[$numberofday].data[$onehourindex]'),
   JSON_EXTRACT(`populartimes`,'$[$numberofday].data[$twohourindex]'),
   (6371*acos(cos(radians('$lat1'))*cos(radians(lat))*cos(radians(lng)-radians('$lng1'))+sin(radians('$lat1'))*sin(radians(lat)))) AS distance
   FROM `pois`
   WHERE poiname LIKE '$input%' OR poiaddress LIKE '$input%' OR JSON_EXTRACT(`types`,'$[0]') = '$input' 
   OR JSON_EXTRACT(`types`,'$[1]') = '$input' OR JSON_EXTRACT(`types`,'$[2]') = '$input'
   OR JSON_EXTRACT(`types`,'$[3]') = '$input' 
   HAVING distance<=('$radius'/1000)
   ORDER BY distance ");
   
   if(mysqli_num_rows($result)>0)
	   
   {
	      
	      $return1=array("statusCode"=>"Success");
	   
	      while($row = $result->fetch_array())
		  {
			  
               $information[] = array(
                                    "id" =>$row[0],
                                    "name" =>  $row[1],
                                    "address" => $row[2],
                                    "lat" => $row[3],
                                    "lng" => $row[4],
									"current_popularity" => $row[5],
									"popularity"=>round(($row[6]+$row[7])/2),
									"distance"=>$row[8],
									"averagepopularity"=>0
                                 );
			  
		  }
	   	   $returns = array_merge($return1,$information);
   }else
	{
		
		$returns["statusCode"]="error1";
		$returns["message"]="Dont find pois";
		
		echo json_encode($returns); 
		exit();
		   
	}
	
	
	$result=$connection->query("SELECT poiid1, AVG(popularity)as average FROM `popularity`
    INNER JOIN `pois`ON(`popularity`.poiid1=`pois`.poiid  AND(
	(6371*acos(cos(radians('$lat1'))*cos(radians(`pois`.lat))*cos(radians(`pois`.lng)-radians('$lng1'))+sin(radians('$lat1'))*sin(radians(`pois`.lat))))<15) 
	AND(`pois`.poiname LIKE '$input%' OR `pois`.poiaddress LIKE '$input%' OR JSON_EXTRACT(`pois`.`types`,'$[0]') = '$input' 
       OR JSON_EXTRACT(`pois`.`types`,'$[1]') = '$input' OR JSON_EXTRACT(`pois`.`types`,'$[2]') = '$input'
       OR JSON_EXTRACT(`pois`.`types`,'$[3]') = '$input'))	
    WHERE HOUR(TIMEDIFF(TIME(NOW()),TIME(date1))) BETWEEN 0 AND 2
	GROUP BY poiid1
	ORDER BY average DESC");
	
	   if(mysqli_num_rows($result)>0)
	   
       {
	      
	      while($row = $result->fetch_array())
		  {
			  
			  for($i=0; $i<count($returns)-1; $i++)
			  {
				  if($returns[$i]["id"]==$row[0])
				  {
					  $returns[$i]["averagepopularity"]=round($row[1]);
					  
				  }
			  }
		  }
	   	 
	   }
	
  echo json_encode($returns);   
  mysqli_close($connection);
   
?>