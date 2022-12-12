<?php

 include "../database.php";
 
 $returns=array();
 
 $numberofusers=(int)$_POST["numberofusers"];
 
 if($numberofusers<5){$numberofusers=5;}
 
 
 $result=$connection->query("SELECT * FROM `pois` LIMIT 10");
 
 if(mysqli_num_rows($result)==0)
 {
	 $returns["statusCode"]="error1";
	 $returns["message"]="Cannot Create Users";
	 echo json_encode($returns);
	 exit(); 
 }
 
 $delete_data="DELETE FROM`users` WHERE is_admin=0";
 
 if($connection->query($delete_data)==false)
 {
	 $returns["statusCode"]="error1";
	 $returns["message"]="Cannot Create Users";
	 echo json_encode($returns);
	 exit();
 }
 
 $usersemail=array();
 
 for($i=1; $i<=$numberofusers;$i++)
 {
	$stmt = $connection -> prepare("INSERT INTO users(username,password,email,is_admin) 
	VALUES(?,?,?,?)");
		
    $stmt -> bind_param("sssi",$username,$password,$email,$is_admin);
	
	 $temp=(string)$i;
	 $username="User".$temp;
	 $email="User".$temp."hotmail.com";
	 $password="User".$temp."pass%"; 
	 $is_admin=0;
						
	$stmt->execute();
	
	array_push($usersemail,$email);
	 
 }
 
 $pois=array();
 
 $result=$connection->query("SELECT poiid,lat,lng FROM `pois`");
 
 if(mysqli_num_rows($result)>0)
 {
	 while($row = $result->fetch_array())
	 {
		                $information[] = array(
                                    "id" =>$row[0],
                                    "lat" => $row[1],
                                    "lng" => $row[2]
                                 );
	 }
	 $pois=array_merge($pois,$information);
	 
	 
 }
 
 date_default_timezone_set("Europe/Athens");
 $startdate = "2021-01-01";
 
 $enddate = date("Y-m-d");
		 
  while (strtotime($startdate) <= strtotime($enddate)) 
	{
		for($user=0; $user<count($usersemail); $user++)
		{
			$visits=rand(5,10);
			
			$poiindex=rand(0,(count($pois)-1));
			
			$userlat=$pois[$poiindex]["lat"];
			$userlng=$pois[$poiindex]["lng"];
			
			$timepoitopoi=0;//minutes
			
			for($visit=0; $visit<$visits; $visit++)
			{
				 	$stmt = $connection -> prepare("INSERT INTO visits(uservisitid,visitpoiid,visittimestamp,spenttime) 
	                VALUES(?,?,?,?)");
					$stmt -> bind_param("sssi",$userid,$poiid,$visittimestamp,$spenttime);
					
					$stmt1=$connection->prepare("INSERT INTO popularity(poiid1,userid1,date1,popularity) VALUES(?,?,?,?)");
					$stmt1->bind_param("sssi",$poiid1,$userid1,$visittimestamp1,$popularity);
					
					$stmt2 = $connection -> prepare("UPDATE pois SET current_popularity=? WHERE poiid=? "); 
		
                    $stmt2 -> bind_param("is",$popularity,$poiid2);
				
		
					$userid=$usersemail[$user];
					$userid1=$usersemail[$user];
					
					$poiid=$pois[$poiindex]["id"];
					$poiid1=$pois[$poiindex]["id"];
					$poiid2=$pois[$poiindex]["id"];
					
					if($visit==0)
					{
					   $hour=rand(0,((23-$visits)-2));
					   
					   if($hour<10)
					   {
						   $hour="0".(string)$hour;
					   }else
					   {
						   $hour=(string)$hour;
					   }
					   
					   $minutes=rand(0,59);
					   if($minutes<10)
					   {
						   $minutes="0".(string)$minutes;
					   }else
					   {
						   $minutes=(string)$minutes;
					   }
					   
					   $seconds=rand(0,59);
					   if($seconds<10)
					   {
						   $seconds="0".(string)$seconds;
					   }else
					   {
						   $seconds=(string)$seconds;
					   }
					   
					   $visittimestamp=$startdate." ".$hour.":".$minutes.":".$seconds;
					   $visittimestamp1=$startdate." ".$hour.":".$minutes.":".$seconds;
					  
					}else
					{
						$minute1=($spenttime+$timepoitopoi);
						$visittimestamp=date ("Y-m-d H:i:s", strtotime("$minute1 minute", strtotime($visittimestamp)));
						$visittimestamp1=date ("Y-m-d H:i:s", strtotime("$minute1 minute", strtotime($visittimestamp)));
					
					}
					
					
					$spenttime=rand(10,120);//minutes
					$popularity=rand(0,100);
					
					$stmt->execute();
					
					$stmt1->execute();
					
					$stmt2->execute();
					
					
					$upperdistance=rand(1,4); //km
					
					
					for($row=0; $row<count($pois); $row++)
					{
						if($row!=$poiindex)
						{
						    $distance=(6371*acos(cos(deg2rad($userlat))*cos(deg2rad($pois[$row]["lat"]))*cos(deg2rad($pois[$row]["lng"])-deg2rad($userlng))+sin(deg2rad($userlat))*sin(deg2rad($pois[$row]["lat"]))));
						    
							if($distance<=$upperdistance)
							{ 
						        
								$poiindex=$row;
								
								$timepoitopoi=round($distance/0.05); // 3km/h => 0.05km/m
								
								
								break;
						    }
						}
							
					}
					
								
			}
			
			$covid=rand(1,10);
			
			if($covid<=7)
			{
					$stmt = $connection -> prepare("SELECT coviddate FROM mycovid WHERE coviduserid=? ORDER BY `coviddate` DESC LIMIT ?"); 
	                $stmt -> bind_param("si",$usersemail[$user],$limit);	
	
	                $limit=1;
	                $stmt->execute();
					$stmt->store_result();
					
					$stmt->bind_result($coviddate);
	
                    $numberofrows = $stmt->num_rows;
 
	                 if($stmt->fetch())
					 {
						 
						 
							 if((strtotime($startdate) - strtotime($coviddate))>(14*24*60*60))
							 {
								
								$stmt = $connection -> prepare("INSERT INTO mycovid(coviddate,coviduserid) 
	                            VALUES(?,?)");
					
                                $stmt -> bind_param("ss",$coviddate,$userid);
				
				                $coviddate=$startdate;
				                $userid=$usersemail[$user];
				
				                $stmt->execute();
							 }
						 
						 
					 }else
					 {
						 	$stmt = $connection -> prepare("INSERT INTO mycovid(coviddate,coviduserid) 
	                        VALUES(?,?)");
					
                            $stmt -> bind_param("ss",$coviddate,$userid);
				
				            $coviddate=$startdate;
				             $userid=$usersemail[$user];
				
				            $stmt->execute();
					 }
				
				
			}
			
			
		}
		
        $startdate = date ("Y-m-d", strtotime("+1 day", strtotime($startdate)));
		
	}
 

 $returns["statusCode"]="success";
 $returns["message"]="Succesful create users";
 echo json_encode($returns);
 
 mysqli_close($connection);
?>