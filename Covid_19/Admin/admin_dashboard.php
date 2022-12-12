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
	   <link rel="stylesheet" href ="admin_dashboard.css">
	   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	   <script	src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
       <script type="text/javascript" src="admin_dashboard.js"></script>
	   
    </head>
	<body>
	
	<div class="container">
	
	
       <div class="top">
	
        <div class="container1">	
	      <div class="topleft">
		  
                 <canvas id="chart1"></canvas>
            
		  </div>
		  
		  <div class="topright">
		  
		  	<label for="Start Day of Week " style="font-size:15px" >Start Day of Week:</label>
			  
			  <input type="date" id="date1" min="2020-01-01" max="2022-12-31">
			  
               
			  <label for="months" style="font-size:15px" >Months:</label>
			  
				     <select name="Months" id="yearmonth"></select>
					   
					    <button id="button4">select</button>
						 <button id="button6">visits</button>
						  <button id="button7">covid</button>
						  <button id="button11">reset</button>
		  
		  
		     <canvas id="chart2"></canvas>
			 

		  </div> 
		  
		 </div>
         
       </div>
	   
       <div class="bottom">
	   
	     <div class="container1">
	      	  <div class="bottomleft">
			     <button id="button13">visit/covid</button>
				 
			  <div id="scroll">
			     <canvas id="chart3"></canvas>
			  </div>
			  
		     </div>
		  
		     <div class="bottomright">
			 
			  <label for="Day " style="font-size:15px" >Day:</label>
			  
			  <input type="date" id="date2" min="2020-01-01" max="2022-12-31">
			  	   
			   <button id="button5">select</button>
			   	<button id="button8">visits</button>
				<button id="button9">covid</button>
				<button id="button12">reset</button>
			   
			  <canvas id="chart4"></canvas>
			 
			 
		     </div>
		 </div>
	   
       </div>
	  
	   </div >

	 
 <div class="main">
	      <div class="sidebar">
		     <div class="information">
			     <h3><?php echo $username ?></h3>
				 <p><?php echo  $TypeOfUser ?></p>
			 </div>
			 
			 <div class="all">
			   <ul>  
				  <li><input type="file" id="file1"><button id="button1">Add</button></li>
				 <li><button id="button2">Delete</button></li>
				 <li><button id="button10">DefaultUsers</button></li>
				 <li><input type="number" id="number" min="5" placeholder="Number Of Users"></li>
				 <li><button id="button3">SignOut</button></li>
			   </ul>
			   <p id="id1"></p>
			 </div>
		  </div>
        </div>  
	</body>
</html>