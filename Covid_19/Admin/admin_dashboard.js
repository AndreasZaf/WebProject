$(document).ready(function(){
	
	
	function deletemessages()
	{
		var deletemessage=setTimeout(function () {
				  
             $("#id1").text("");
				  
		}, 3000);
	}
	
	 		
	$.ajax({
		
		url:"LoadDataChart1.php",
		type:"POST",
		
		success:function(data1)
		{
			var values=[];
			
			var data1=JSON.parse(data1);
			
			values.push(data1.totalvisits);
			values.push(data1.totalcovid);
			values.push(data1.visitcovid);
			
				
			var chart1=$("#chart1").attr("id");
						
			var bargraph1 = new Chart(chart1, {
					type:"bar",
					data:{
					    labels:["visit","covid","covid/visit"],
					    datasets:[
						   {
							   label:"visit",
							   backgroundColor:["green","red","blue"],
							   color:"#fff",
							   data:values
						   },
						   {
							   label:"covid",
							   backgroundColor:"red"
						   },
						   {
							   label:"covid/visit",
							   backgroundColor:"blue"
						   }
					    ]
					},
					options: {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0
							}
						}]
					}
				  }
							
				});	
								
		}
		
	});
	
 
	var chart3=$("#chart3").attr("id");
			
    var pie = new Chart(chart3, {
		
			type:"pie",
				data:{
					   labels:[],
					    datasets:[
						   {
							   label:[],
							   backgroundColor:[],
							   color:"#fff",
							   data:[]
						   }
					    ]
						
					},
					options:[{
														
						}]
					
		
	});
	
	
	var visittypes=[];
	var covidtypes=[];
	var visits=[];
	var covid=[];
	var visitcolors=[];
	var covidcolors=[];
		
	$.ajax({
		
		url:"LoadDataChart3.php",
		type:"POST",
		
		success:function(data1)
		{
			
			var data1=JSON.parse(data1);
		
			if(data1.statusCodeVisits=="Success")
			{
			     Object.keys( data1 ).forEach(function( key ) {
					 
				   if(key!="statusCodeVisits" && key!= "statusCodeCovid" && data1[key].hasOwnProperty("visittypes"))
				   {
					   visittypes.push(data1[key].visittypes);
					   visits.push(data1[key].visits);
				   }
				   
				 });  
				 
				 
				for(var i=0; i<visits.length; i++)
				{
					visitcolors.push("#"+Math.floor(Math.random()*16777215).toString(16));
				}
				
				   				   
			}else if(data1.statusCodeVisits=="error1"){}
			   
			if(data1.statusCodeCovid=="Success")
			{
				
				Object.keys(data1).forEach(function(key) {
					
				   if(key!="statusCodeVisits" && key!= "statusCodeCovid" && data1[key].hasOwnProperty("covidtypes"))
				   {
					   covidtypes.push(data1[key].covidtypes);
					   covid.push(data1[key].covid)
					   
				   }
				   
				});
				
				
				for(var i=0; i<covid.length; i++)
				{
					covidcolors.push("#"+Math.floor(Math.random()*16777215).toString(16));
				}
				
				   
			}else if(data1.statusCodeCovid=="error1"){}
			
			
		    pie.options.legend.display=false;
			
			pie.data.datasets[0].label="visits";
			
			pie.options.title.display=true;
			pie.options.title.text="visits per poi";
			
		    for(var i=0; i< visittypes.length; i++)
		    {
			   pie.data.labels.push(visittypes[i]);			
		    }
		
		    for(var i=0; i<visits.length;i++)
		    {
			   pie.data.datasets[0].data.push(visits[i]);
			    pie.data.datasets[0].backgroundColor.push(visitcolors[i]);
		    }
		
		    pie.update();
							
		}
		
	});
	
 		
	$("#button1").on("click",function()
	{
		
		var choosefile=$("#file1").val();
		
		if(choosefile.length!=0)
		{
              
			    var file = new FormData();
                var file1 = $("#file1")[0].files[0];
							
                file.append("file", file1);
									
			      $.ajax({
		          url:"InsertData.php",
				  type:"POST",
				  data:file,
				  contentType:false,
                  processData: false,
				  cache:false,
		          success:function(data1)
		          {
					  $("input[type=file]").val("");
					  
			         var data1=JSON.parse(data1);
			   
			         if(data1.statusCode=="success" || data1.statusCode=="error1")
			         {
				          $("#id1").text(data1.message);
					      $("#id1").css("fontSize","15px");
						  
						  deletemessages();
				   
			         }
					
					 
		        }
		
			
		});
		
		
	  }
		
	});
	
	$("#button2").on("click",function(){
		
		$.ajax({
		    url:"delete.php",
		 
		    success:function(data1)
		    {
			
			   var data1=JSON.parse(data1);
			   
			   if(data1.statusCode=="success" || data1.statusCode=="error1")
			   {
				   $("#id1").text(data1.message);
					$("#id1").css("fontSize","15px");
					
					deletemessages();
					
					setTimeout(function(){
						
						location.reload();
						
					},2000);
				    
			   }
			   
			   
		    }
		
			
		});
	   
	});
	
	
	$("#button3").on("click",function(){
		
		$.ajax({
		 url:"../logout.php",
		 
		 success:function(data1)
		  {
			var data1=JSON.parse(data1);
			
			window.location.href=data1.url;
		  }
		
			
		});
		
	});
	
		
	var visitdays=[];
	var coviddays=[];
	var visitsperday=[];
	var covidperday=[];
	
    var chart2=$("#chart2").attr("id");
	
	var bargraph2 = new Chart(chart2, {
					type:"bar",
					data:{
					    labels:[],
					    datasets:[
						   {
							   label:"visitsperdays",
							   backgroundColor:[],
							   color:"#fff",
							   data:[]
						   },
						   {
							   label:"covidperdays",
							   backgroundColor:[],
							   color:"#fff",
							   data:[]
						   }
					    ]
						
					}
					,
					options: {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0
							}
						}]
					}
				  }
							
				});
	
	
	$("#button4").on("click",function(){
		
		var date1 =$("#date1").val();
		var select1=$("#yearmonth").val();
		
		if(date1.length!=0)
		{
			visitdays=[];
	        coviddays=[];
	        visitsperday=[];
	        covidperday=[];
			
		    bargraph2.data.datasets[0].data=[];
		    bargraph2.data.datasets[0].backgroundColor=[];
			
		    bargraph2.data.datasets[1].data=[];
		    bargraph2.data.datasets[1].backgroundColor=[];
			   
			bargraph2.data.labels=[];
			
			bargraph2.update();
			
		   $.ajax({
		
		    url:"LoadDataChart2Weeks.php",
		    type:"POST",
			data:{date:date1},
		    cache:false,
		    success:function(data1)
		    {
				
			   $("#date1").val("");
			   			   
			   var data1=JSON.parse(data1);
			   
			   if(data1.statusCodeVisits=="Success")
			   {
				   			   
			   	Object.keys( data1 ).forEach(function( key ) {
					
					if(key!="statusCodeVisits" && key!="statusCodeCovid" && data1[key].hasOwnProperty("visitsday"))
					{
					    visitdays.push(data1[key].visitsday);
                         visitsperday.push(data1[key].visits);						
						
					}
				
				
			    });
				   
			   }else if(data1.statusCodeVisits=="error1"){}
			   
			   if(data1.statusCodeCovid=="Success")
			   {
				   Object.keys( data1 ).forEach(function( key ) {
					   
				   	if(key!="statusCodeVisits" && key!="statusCodeCovid" && data1[key].hasOwnProperty("covidday"))
					{
						coviddays.push(data1[key].covidday);
                        covidperday.push(data1[key].covid);
						
					}
					
				   });	
				   
				   
			   }else if(data1.statusCodeCovid=="error1"){}
			   			   
		    }
		  
		  });
		}
		
		if(select1!=null)
		{
			
			visitdays=[];
	        coviddays=[];
	        visitsperday=[];
	        covidperday=[];
			
		    bargraph2.data.datasets[0].data=[];
		    bargraph2.data.datasets[0].backgroundColor=[];
			
		    bargraph2.data.datasets[1].data=[];
		    bargraph2.data.datasets[1].backgroundColor=[];
			   
			bargraph2.data.labels=[];
			
			bargraph2.update();
			
			$.ajax({
		
		       url:"LoadDataChart2Months.php",
		       type:"POST",
			   
			   data:{Year_Month:select1},
			   cache:false,
		  
		       success:function(data1)
		       {
			        $("#yearmonth").val(0);
					
					var data1=JSON.parse(data1);
					
				   
			   if(data1.statusCodeVisits=="Success")
				   
			   {
				   			   
			   	Object.keys( data1 ).forEach(function( key ) {
					
					if(key!="statusCodeVisits" && key!="statusCodeCovid" && data1[key].hasOwnProperty("visitsday"))
					{
					    visitdays.push(data1[key].visitsday);
                        visitsperday.push(data1[key].visits);						
						
					}
				
				
			    });
				   
			   }else if(data1.statusCodeVisits=="error1"){}
			   
			   if(data1.statusCodeCovid=="Success")
			   {
				   Object.keys( data1 ).forEach(function( key ) {
					   
				   	if(key!="statusCodeVisits" && key!="statusCodeCovid" && data1[key].hasOwnProperty("covidday"))
					{
						coviddays.push(data1[key].covidday);
                        covidperday.push(data1[key].covid);
					}
					
				   });	
				   
				   
			   }else if(data1.statusCodeCovid=="error1"){}
				    
		       }
		  
		  });
		}
		
	});
	
	
	var visithours=[];
	var covidhours=[];
    var visitsperhour=[];
    var covidperhour=[];	
					
	var chart4=$("#chart4").attr("id");
	
	var line1 = new Chart(chart4, {
		            type:"line",
					data:{
					    labels:[],
					    datasets:[
						   {
							   label:"visitsperhour",
							   backgroundColor:[],
							   color:"#fff",
							   data:[],
							   fill:false,
							   borderColor:["red"]
						   },
						   {
							   label:"covidperhour",
							   backgroundColor:[],
							   color:"#fff",
							   data:[],
							   fill:false,
							   borderColor:["yellow"]
						   }
					    ]
					}
					,
					options: {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0
							}
						}]
					}
				  }
							
				});
	
		$("#button5").on("click",function(){
		
		var date2 =$("#date2").val();
		
		if(date2.length!=0)
		{
			visithours=[];
	        covidhours=[];
            visitsperhour=[];
            covidperhour=[];
				
		    line1.data.datasets[0].data=[];
		    line1.data.datasets[0].backgroundColor=[];
			
		    line1.data.datasets[1].data=[];
		    line1.data.datasets[1].backgroundColor=[];
			   
			line1.data.labels=[];
			
			line1.update();
			
		   $.ajax({
		
		    url:"LoadDataChart4.php",
		    type:"POST",
			data:{date:date2},
		    cache:false,
		    success:function(data1)
		    {
			   $("#date2").val("");
			   
			   var data1=JSON.parse(data1);
			   
			   	if(data1.statusCodeVisits=="Success")
				   
			   {
				   			   
			   	Object.keys( data1 ).forEach(function( key ) {
					
					if(key!="statusCodeVisits" && key!="statusCodeCovid" && data1[key].hasOwnProperty("visithours"))
					{
						
					    visithours.push(data1[key].visithours);
                        visitsperhour.push(data1[key].visits);						
						
					}
				
			    });
				   
			   }else if(data1.statusCodeVisits=="error1"){}
			   
			   if(data1.statusCodeCovid=="Success")
			   {
				   Object.keys( data1 ).forEach(function( key ) {
					   
				   	if(key!="statusCodeVisits" && key!="statusCodeCovid" && data1[key].hasOwnProperty("covidhours"))
					{
						covidhours.push(data1[key].covidhours);
                        covidperhour.push(data1[key].covid);
						
					}
					
				   });	
				   		   
			   }else if(data1.statusCodeCovid=="error1"){}
			   
		    }
		  
		  });
		}
		
	});
	
	$("#button6").on("click",function(){
		
		
	if(bargraph2.data.labels.length==0)
	{
		for(var i=0; i< visitdays.length; i++)
		{
			bargraph2.data.labels.push(visitdays[i]);			
		}
	}		
		
	if(bargraph2.data.datasets[0].data.length==0)
	{		
		for(var i=0; i<visitsperday.length;i++)
		{
			bargraph2.data.datasets[0].data.push(visitsperday[i]);
			bargraph2.data.datasets[0].backgroundColor.push("blue");
		}
	}else
	{
		bargraph2.data.datasets[0].data=[];
		bargraph2.data.datasets[0].backgroundColor=[];
		
	}
	
	bargraph2.update();
		
	});
	
	$("#button7").on("click",function(){
		
	   if(bargraph2.data.labels.length==0)
	   {
		 
		for(var i=0; i< coviddays.length; i++)
		{
			bargraph2.data.labels.push(coviddays[i]);			
		}
		
	   }
			
		if(bargraph2.data.datasets[1].data.length==0)
		{			
		   for(var i=0; i<covidperday.length;i++)
		   {
			bargraph2.data.datasets[1].data.push(covidperday[i]);
			bargraph2.data.datasets[1].backgroundColor.push("green");
		   }
		}else
		{
			bargraph2.data.datasets[1].data=[];
			bargraph2.data.datasets[1].backgroundColor=[];
		}
		
		bargraph2.update();
	});
	
	
    $("#button8").on("click",function(){
		
	  if(line1.data.labels.length==0)
	  {
		for(var i=0; i< visithours.length; i++)
		{
			
			line1.data.labels.push(visithours[i]);			
		}
	  }
		
	  if(line1.data.datasets[0].data.length==0)
	  {	
		for(var i=0; i<visitsperhour.length;i++)
		{
			line1.data.datasets[0].data.push(visitsperhour[i]);
			line1.data.datasets[0].backgroundColor.push("red");
		}
	  }else
	  {
			line1.data.datasets[0].data=[];
			line1.data.datasets[0].backgroundColor=[];
	  }
		
		line1.update();
		
	});
	
	
	$("#button9").on("click",function(){
		
	 if(line1.data.labels.length==0)
	  {
		for(var i=0; i< covidhours.length; i++)
		{
			line1.data.labels.push(covidhours[i]);			
		}
	  }
			
	if(line1.data.datasets[1].data.length==0)
	{
		
		for(var i=0; i<covidperhour.length;i++)
		{
			line1.data.datasets[1].data.push(covidperhour[i]);
			line1.data.datasets[1].backgroundColor.push("yellow");
		}
		
	}else
	{
			line1.data.datasets[1].data=[];
			line1.data.datasets[1].backgroundColor=[];
	}
		
		line1.update();
		
	});
	
	$("#button10").on("click",function(){
		
		var number=$("#number").val();
		
		if(number.length!=0)
		{
			
		 $.ajax({
			
			url:"defaultusers.php",
			type:"POST",
			data:{numberofusers:number},
			cache:false,
			success:function(data1)
			{
				$("#number").val("");
				var data1=JSON.parse(data1);
		        if(data1.statusCode=="success" || data1.statusCode=="error1")
				{
					
					$("#id1").text(data1.message);
					$("#id1").css("fontSize","15px");
					
					deletemessages();
					
					setTimeout(function(){
						
						location.reload();
						
					},2000);
						
				}
				
			}
				
		 });
		
	  }
		
	});
	
	$("#button11").on("click",function(){
		
		    visitdays=[];
	        coviddays=[];
	        visitsperday=[];
	        covidperday=[];
			
		    bargraph2.data.datasets[0].data=[];
		    bargraph2.data.datasets[0].backgroundColor=[];
			
		    bargraph2.data.datasets[1].data=[];
		    bargraph2.data.datasets[1].backgroundColor=[];
			   
			bargraph2.data.labels=[];
			
			bargraph2.update();
		
	});
	
	
	$("#button12").on("click",function(){
		
			visithours=[];
	        covidhours=[];
            visitsperhour=[];
            covidperhour=[];
				
		    line1.data.datasets[0].data=[];
		    line1.data.datasets[0].backgroundColor=[];
			
		    line1.data.datasets[1].data=[];
		    line1.data.datasets[1].backgroundColor=[];
			   
			line1.data.labels=[];
			
			line1.update();
	
	});
	
	$("#button13").on("click",function(){
		
		pie.data.datasets[0].data=[];
		pie.data.datasets[0].backgroundColor=[];
		
		pie.data.labels=[];
		
		pie.update();
		
		if(pie.data.datasets[0].label=="visits")
		{
					    
			pie.data.datasets[0].label="covid";
			
			pie.options.title.text="covid per poi";
			
		    for(var i=0; i< covidtypes.length; i++)
		    {
			   pie.data.labels.push(covidtypes[i]);			
		    }
		
		    for(var i=0; i<covid.length;i++)
		    {
			   pie.data.datasets[0].data.push(covid[i]);
			   pie.data.datasets[0].backgroundColor.push(covidcolors[i]);
		    }
			
		}else if(pie.data.datasets[0].label=="covid")
		{
			
			pie.data.datasets[0].label="visits";
			
			pie.options.title.text="visits per poi";
			
		    for(var i=0; i< visittypes.length; i++)
		    {
			   pie.data.labels.push(visittypes[i]);			
		    }
		
		    for(var i=0; i<visits.length;i++)
		    {
			   pie.data.datasets[0].data.push(visits[i]);
			   pie.data.datasets[0].backgroundColor.push(visitcolors[i]);
		    }
			
		}
		
		pie.update();
		
	});
	
	
	$("#date1").on("click",function(){
				 
            var select1=$("#yearmonth").val();	
			var date2=$("#date2").val();
			
			if(select1!=null)
			{
				$("#yearmonth").val(0);
			}
     
            if(date2.length!=0)
			{
			  
				 $("#date2").val("");
			
			}				
                     
     });
	 
	 	$("#yearmonth").on("click",function(){
				 
            var date11=$("#date1").val();
			var date2=$("#date2").val();
			
			if(date1.length!=0)
			{
				 $("#date1").val("");
			}	

            if(date2.length!=0)
			{
			  
				 $("#date2").val("");
			}			
                     
     });
	 
	 	$("#date2").on("click",function(){
				 
            var select1=$("#yearmonth").val();	
			var date1=$("#date1").val();
			
			if(select1!=null)
			{
				$("#yearmonth").val(0);
			}
     
            if(date1.length!=0)
			{
			  
				 $("#date1").val("");
			
			}				
                     
     });
	 
	 
	var startYear = 2020;
    var endYear = new Date().getFullYear();
	
	$("#yearmonth").append($("<option />").val("").html(""));
    for (i = endYear; i > startYear; i--)
    {
		for(j=12; j>0; j--)
		{
			 if(j<10)
			 {
				  $("#yearmonth").append($("<option />").val(i+"-"+"0"+j).html(i+"-"+"0"+j));
			 }else
			 {
				 $("#yearmonth").append($("<option />").val(i+"-"+j).html(i+"-"+j));
			 }
			 
		}
		
    }
	 
});