$(document).ready(function()
{
	function deletemessages()
	{
		var deletemessage=setTimeout(function () {
				  
             $("#id1").text("");
				  
		}, 3000);
	}
	
	function checkemptyusername(username1)
	{
		if(username1.length==0)
	   {
		  if($("#p1").length==0)
          {		  
		        $("<p id=p1> Username field is empty </p>").insertBefore("#Username1");
				$("#p1").css("color","#FF0000");
				$("#Username1").css("border-color","#FF0000");
				
		  }
		  
		  return false;
		  
	   }else
	   {
		   $("#p1").remove();
		   $("#Username1").css("border-color","");
		   return true;
	   }
	   return true;
		
	}
	
	function checkemptyemail(email1)
	{
	   if(email1.length==0)
	   {
		    
		    if($("#p2").length==0)
			{
				$("<p id=p2> Email field is empty </p>").insertBefore("#Email1");
				$("#p2").css("color","#FF0000");
				$("#Email1").css("border-color","#FF0000");
			}
			
		   return false;
	   }else
	   {
		   $("#p2").remove();
		   $("#Email1").css("border-color","");
		   return true;
	   }
		return true;
	}
	
	function checkemptypassword(password1)
	{
	   if(password1.length==0)
	   {
		     
		   	if($("#p3").length==0)
			{
					$("<p id=p3> Password field is empty </p>").insertBefore("#Password1");
					$("#p3").css("color","#FF0000");
					$("#Password1").css("border-color","#FF0000");
			}
			
			return false;
			
		   
	   }else
       {
		   $("#p3").remove();
		   $("#Password1").css("border-color","");
		   return true;
	   }
	   return true;
	}
	
	function checkconfirmpassword(confirm_password1,password1)
	{
	   if(confirm_password1.length==0)
       {
		 
		 if($("#p4").length==0)
		 {
			 $("<p id=p4> Confirm Password field is empty </p>").insertBefore("#Confirm-Password1");
			 $("#p4").css("color","#FF0000");
			 $("#Confirm-Password1").css("border-color","#FF0000");
		 }
		 
		 return false;
		 
	   }else
	   {
		   $("#p4").remove();
		   $("#Confirm-Password1").css("border-color","");
		   
		   if(password1!==confirm_password1 && password1.length>0)
		   {
			  $("#id1").text("Confirm password is not same with password");
			  $("#id1").css("fontSize","15px");
			  return false;
		   }
	   }
	   return true;
	}
	
	
   $("#submit1").on("submit",function()
   {
	   var okname,okemail,okpassword,okconfirmpassword;
	   var username1=$("#Username1").val().trim();
	   var email1=$("#Email1").val().trim();
	   var password1=$("#Password1").val().trim();
	   var confirm_password1=$("#Confirm-Password1").val().trim();
	   

       okname=checkemptyusername(username1);
	   okemail=checkemptyemail(email1);
	   okpassword=checkemptypassword(password1);
	   okconfirmpassword=checkconfirmpassword(confirm_password1,password1);
	  
	   if(okname==true && okemail==true && okpassword==true &&okconfirmpassword==true)
	   {
		   
		   $.ajax({
			   type:"POST",
			   url:"sign_up_in.php",
			   data:{
				  type:1,
			      username:username1,
			      email:email1,
			      password:password1
			   },
			   cache:false,
			   
			   success:function(data1)
			   {
				   $("#submit1")[0].reset();
				   var data1=JSON.parse(data1);
				   if(data1.statusCode=="Success")
				   {
					   window.location.href=data1.url;

				   }else if(data1.statusCode=="error1")
				   {
					   
					   if(typeof data1.username!='undefined')
					   {
						   if($("#p1").length==0)
                           {		  
		                       $("<p id=p1>"+ data1.username +"</p>").insertBefore("#Username1");
				               $("#p1").css("color","#FF0000");
				               $("#Username1").css("border-color","#FF0000");
		                   } 
					   }
					   
					   if(typeof data1.email!='undefined')
					   {
						  	if($("#p2").length==0)
			               {
				               $("<p id=p2>"+ data1.email +"</p>").insertBefore("#Email1");
				               $("#p2").css("color","#FF0000");
				               $("#Email1").css("border-color","#FF0000");
			                } 
					   }
					   
			            
				   }else if(data1.statusCode=="error2")
				   {
					   if(typeof data1.username!='undefined')
					   {
						   if($("#p1").length==0)
                           {		  
		                       $("<p id=p1>"+ data1.username +"</p>").insertBefore("#Username1");
				               $("#p1").css("color","#FF0000");
				               $("#Username1").css("border-color","#FF0000");
		                   }
						   
						   
					   }
					   
					   if(typeof data1.email!='undefined')
					   {
						   if($("#p2").length==0)
			               {
				               $("<p id=p2>"+ data1.email +"</p>").insertBefore("#Email1");
				               $("#p2").css("color","#FF0000");
				               $("#Email1").css("border-color","#FF0000");
			                }
						   
					   }
					   
					   if(typeof data1.password!='undefined')
					   {
						   if($("#p3").length==0)
						   {
						     $("<p id=p3>"+ data1.password +"</p>").insertBefore("#Password1");
					         $("#p3").css("color","#FF0000");
					         $("#Password1").css("border-color","#FF0000");
						   }
					   }
					    
				   }else if(data1.statusCode=="error3")
				   {
					  		$("#id1").text(data1.message);
					        $("#id1").css("fontSize","15px");
							
							deletemessages();
				   }
			   }
			   
		   });
		   
		   
	   }
	   	   
   });
   
  
   $("#submit2").on("submit",function()
   {
	   var okname,okemail
	   var username1=$("#Username1").val().trim();
	   var password1=$("#Password1").val().trim();
	   
	   okname=checkemptyusername(username1);
	   okemail=checkemptypassword(password1);
	  
	   if(okname==true && okemail==true)
	   {
		   $.ajax({
			   url:"sign_up_in.php",
			   type:"POST",
			   data:{
				  type:2,
			      username:username1,
			      password:password1,
				  width:$(window).width()
			   },
			   cache:false,
			   success:function(data1)
			   {
				   $("#submit2")[0].reset();
				   var data1=JSON.parse(data1);
				   if(data1.statusCode=="Success")
				   {
					   window.location.href=data1.url;
					    
				   }else if(data1.statusCode=="error4" ||  data1.statusCode=="error5")
				   {
					   		$("#id1").text(data1.message);
					        $("#id1").css("fontSize","15px");
							
							deletemessages();
					     
				   }
			   }		  
		   });
		   
	   }
	   
   });
 
});
   