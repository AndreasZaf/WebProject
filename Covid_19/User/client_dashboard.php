<?php

session_start();

if (!isset($_SESSION["login"]))
{
    header("Location: signin.html");
}else
{
			
	if($_SESSION["login"]=="yes")
	{
	  $username=$_SESSION["username"];
	  $TypeOfUser=$_SESSION["TypeOfUser"];
	}
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
       <title>Covid19Book</title>
	   <meta charset="UTF-8">
	   <meta name="viewport" content="width=device-width,initial-scale=1"/>
	   <link rel="stylesheet" href ="client_dashboard.css">
	   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
                 integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
                 crossorigin=""/>		 
       <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
               integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
               crossorigin=""></script>		   
	   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	   <script type="text/javascript" src="client_dashboard.js"></script>
	   
    </head>
	<body> 
	  
	     <div id="map"></div>
		 
       <div class="main">
	   
	   <div class="smallsidebar" hidden="yes">
	     <button id="button10">Show</button>
	   </div>
	   
	      <div class="sidebar">
		    <button id="button9">Hide</button>
		    <div class="information">
			  
			   <h3><?php echo $username ?></h3>
			   <p><?php echo  $TypeOfUser ?></p>
			
			</div>
		     
			 <div class="DropDown">
			    <button id="button1">Operations</button>
				  <ul id="dropdown" hidden="yes">
				        <li><input type="search" id="input1" placeholder="Search Pois"> <button id="button2">Search</button></li>
				        <li><button id="button3">AddCases</button></li>
						<div id="flip1" hidden="yes" title="AddCases">
						  <li><input type="date" id="date1"><button id="button7">AddCase</button></li>
						</div>
					    <li><button id="button4">ListCases</button></li>
					    <li><button id="button5">Profile</button></li>
					    <li><button id="button6">SignOut</button></li>
						<p id="id1"></p>
				   </ul>
			 </div>
		  </div>
        </div>			
	</body>
</html>