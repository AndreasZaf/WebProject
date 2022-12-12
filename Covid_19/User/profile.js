$(document).ready(function()
{
	function deletemessages()
	{
		var deletemessage=setTimeout(function () {
				  
             $("#l4").text("");
				  
		}, 5000);
	}
		
	$.ajax({
		
		url:"UserHistory.php",
		type:"POST",
		cache:false,
		
		success:function(data1)
		{
			
			var data1=JSON.parse(data1);
			
			
			if(data1.statusCodeVisits=="Success")
			 {
				 
				 Object.keys( data1 ).forEach(function( key ) {
					 
					 
					 if(key!="statusCodeVisits" && key!="statusCodeCovid" && data1[key].hasOwnProperty("visittimestamp"))
					 { 
				 
						  $("#content1").append("<p id=id1>"+data1[key].visittimestamp +"<span id=span1>"+data1[key].spenttime+"&nbsp;m"+"<span id=span2 >"+"</span>"+"</p>");
						 
					 }
					  
				 });
				 
			 }else if(data1.statusCodeVisits=="error1"){}
			 
			 if(data1.statusCodeCovid=="Success")
			 {
				 Object.keys(data1).forEach(function(key)
				 {
					 if(key!="statusCodeCovid" && key!="statusCodeVisits" && data1[key].hasOwnProperty("coviddate"))
					 {
						 $("#content2").append("<p id=id1>"+data1[key].coviddate +"</p>");
					 }
				
				 });
				   
			 }else if(data1.statusCodeCovid=="error1"){}
			
		}
		
		
	});
	
	
	$("#submit1").on("submit",function(){
		
	   var ok=true;
	   var newusername1=$("#newusername").val().trim();
	   var newpassword1=$("#newpassword").val().trim();
	   var confirmnewpassword1=$("#confirm-newpassword").val().trim();
	   
	   if(newusername1.length==0){ok=false;}
	   if(newpassword1.length==0){ok=false;}
	   
	   if(confirmnewpassword1.length==0)
	   {
		   ok=false;
	   }else
	   {
		   if(confirmnewpassword1!=newpassword1)
		   {
			    $("#l4").text("Password is not same with Confirm Password");
				deletemessages();
				
			   ok=false;
		   }
	   }
	   
	   
	   if(ok==true)
	   {
	    $.ajax({
			   url:"update.php",
			   type:"POST",
			   data:{
				   newusername:newusername1,
				   newpassword:newpassword1
			   },
			   cache:false,
			   success:function(data1)
			   {
				   
				    $("#submit1")[0].reset();
				    
				   var data1=JSON.parse(data1);
				     
				   if(data1.statusCode=="Success")
				   {
				
					   $("#left").text(data1.username);
					   
					   $("#l4").text(data1.message);
					   
					   deletemessages();
					   
					   
				   }else if(data1.statusCode=="error1")
				   {
					   
						
				   }else if(data1.statusCode=="error2" || data1.statusCode=="error3" )
				   {
					   
					   $("#l4").text(data1.message);
					   
					   deletemessages();
				   }
			   }
			    
		   });
	   }
	   
	 });
	
});