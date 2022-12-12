<?php

     include "../database.php";
 
    $returns=array();
	
	$deletepois=false;
	$deleteusers=false;
    
	$delete_data1="DELETE FROM `pois`";
	
	if($connection->query($delete_data1)==true ){$deletepois=true;}
	   
	$delete_data2="DELETE FROm`users` WHERE is_admin=0";

	if($connection->query($delete_data2)==true){$deleteusers=true;}
	
	if($deletepois==true || deleteusers==true)
	{
			$returns["statusCode"]="success";
			 $returns["message"]="Successful Delete";
			 
		
	}else
	{
			  $returns["statusCode"]="error1";
			 $returns["error1"]="Unsuccessful Delete";
			 
	}
	
	 echo json_encode($returns);
	   
	   
  mysqli_close($connection);
 
?>