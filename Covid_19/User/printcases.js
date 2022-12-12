$(document).ready(function(){

  	$.ajax({
		
		url:"ListCases.php",
		type:"POST",
		cache:false,
		success:function(data1)
		{
				
		   var data1=JSON.parse(data1);
		   
		   if(data1.statusCode=="success")
		   {
			  
			   
		   	    Object.keys( data1 ).forEach(function( key ) {
					
					
					 if(key!="statusCode")
					 {
				   
				       $("tbody").append("<tr>"+"<th>"+data1[key].name+"</th>"+"<th>"+data1[key].address+"</th>"+"<th>"+data1[key].timedate+"</th>"+"</tr>");
					 }
			    });
			   
			   
		   }else if(data1.statusCode=="error1"){}
		  
		}
		
	});

});