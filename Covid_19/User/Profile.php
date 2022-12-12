<?php

session_start();

 if($_SESSION["login"]=="yes")
 {
	$username=$_SESSION["username"];
	$email=$_SESSION["email"];
 }

?>

<!DOCTYPE html>

<html lang="en">
   <head>
       <title>Covid19Book</title>
	   <meta charset="UTF-8">
	   <meta name="viewport" content="width=device-width,initial-scale=1"/>
	   <link rel="stylesheet" href ="profile.css">
	   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	   <script type="text/javascript" src="profile.js"></script>
   </head>

<body>

  <div class="up">
    <p id="left"><?php echo $username?></p>
	<p id="right"><?php echo $email?></p>
  </div>
  
  <div class="changes">
   
       <form class ="class1" id="submit1" onsubmit="return false">
	      
	            <div class="control">
                 <input type="text" autocomplete="off"  placeholder="NewUsername" id="newusername" >
			    </div>
	          
			  <div class="control">
                 <input type="password" autocomplete = "off"  placeholder="NewPassword" 
	             id="newpassword">
	          </div>
			  
			  <div class ="control">
                 <input type="password" autocomplete = "off"  placeholder="Confirm NewPassword" 
	             id="confirm-newpassword">
	          </div>
			  
			  <button type="submit">SaveChanges</button>
			  
			  <p id="l4"></p>
	   </form>
	    
  </div>
  
  <div class="history">
  
  
     <div class="leftsplit">
	  
	    <h2>Visits</h2>
		<table>
		<tr>
		   <th>DATE-TIME<th>
		   <th>SPENTTIME</th>
		</tr>
		</table>
		
	   	<div id="scrollbox" >
		   <div id="content1" >
		   </div>
	    </div>
	
	 </div>
	 
	 <div class="rightsplit">
	 
	  <h2>Covid Positive Case</h2>
	  <table>
	     <tr><th>DATE</th></tr>
	   <table>
	 
	    <div id="scrollbox" >
		   <div id="content2" >
			
		   </div>
	    </div>
	 	   
	</div>
  
  </div>
  
  
</body>

</html>
