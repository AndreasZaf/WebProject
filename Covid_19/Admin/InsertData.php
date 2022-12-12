<?php

 include "../database.php";
 
  $returns=array();
  
  $filename=$_FILES["file"]["name"]; 
   
  $file = file_get_contents($filename);
  
   $newdata = json_decode($file);
					     
    $atleastone=false;
	
   foreach($newdata as $nd)
  {
	$poiid=$nd->id;
	$poiname=$nd->name;
	$poiaddress=$nd->address;
	$types=json_encode($nd->types);
	$lat=$nd->coordinates->lat;
	$lng=$nd->coordinates->lng;
	if(isset($nd->rating))
	{
			$rating=$nd->rating;
	}
		
	if(isset($nd->rating_n))
	{
			$rating_n=$nd->rating_n;
	}
	if(isset($nd->current_popularity))
	{
			$current_popularity=$nd->current_popularity;
	}
		
	$populartimes=json_encode($nd->populartimes);
		
	if(isset($nd->time_spent))
	{
			$time_spent=json_encode($nd->time_spent);
	}
	

	
	$stmt = $connection -> prepare("SELECT *  FROM pois WHERE poiid=?"); 
	$stmt -> bind_param("s",$poiid);	
	
	$stmt->execute();
	$stmt->store_result();
	
    $numberofrows = $stmt->num_rows;
	
	if(($numberofrows) > 0)
	{
		if($atleastone==false)
		{
			$atleastone=true;
		}
		
		$stmt = $connection -> prepare("UPDATE pois SET rating=?,rating_n=?,current_popularity=?,populartimes=?,time_spent=? WHERE poiid=? "); 
		
        $stmt -> bind_param("diisss",$rating,$rating_n,$current_popularity,$populartimes,$time_spent,$poiid);
				
		$stmt->execute();
		
			
	}else
	{
		if($atleastone==false)
		{
			$atleastone=true;
		}
		
		$stmt = $connection -> prepare("INSERT INTO pois(poiid,poiname,poiaddress,types,lat,lng,rating,rating_n,current_popularity,populartimes,time_spent) 
		VALUES(?,?,?,?,?,?,?,?,?,?,?)");
		
        $stmt -> bind_param("ssssdddiiss",$poiid, $poiname, $poiaddress,$types,$lat,$lng,$rating,$rating_n,$current_popularity,$populartimes,$time_spent);
						
		$stmt->execute();
			
	}
	
	$stmt->close();	
	
  }

  if($atleastone==true)
   {
			   $returns["statusCode"]="success";
			   $returns["message"]="Successful Insert Data";
		   	   echo json_encode($returns);
			   
   }else if($atleastone==false)
   {
			   	$returns["statusCode"]="error1";
			   $returns["message"]="No Insert Data";
		   	   echo json_encode($returns);
   }

$connection->close();
  
?>
