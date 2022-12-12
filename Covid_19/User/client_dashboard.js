$(document).ready(function(){
	
	var markers=new Array();	
	var radius=15000;	
	var marker,lat,lng,zoom_from_my_position;
	var map1=$("#map").attr("id");
	var map=L.map(map1);
    L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);
	map.setView([38.246639,21.734573],15);
	
	if('geolocation' in navigator)
	{ 
	  
		navigator.geolocation.getCurrentPosition(position=>{
			lat=position.coords.latitude;
			lng=position.coords.longitude;
				 
	          map.setView([lat,lng],15);
		 
	         L.marker([lat, lng]).addTo(map);
			 
            var circle = L.circle([lat,lng], radius).addTo(map);
				
		});
	}else
	{
		console.log("geolocotation not available");
	}
	

	$("#button1").on("click",function(){
		
		    
		    $("#flip1").hide();
			
			if($("#button2").is(":hidden"))
			{
				$("#button2").show();
			}else
			{
				setTimeout(function(){
					
					
					$("#button2").hide();
					
					
				},400);
			}
				
			$("#dropdown").slideToggle("slow");	
						
	});
	
	$("#button2").on("click",function()
	{
		var input1=$("#input1").val();
		
		if(input1.length!=0)
		{
				
	         $.ajax({
		
		         url:"LoadPois.php",
		         type:"POST",
		         data:{
					input:input1,
			        radius:radius,
		            lat:lat,
			        lng:lng},
		        cache:false,
		        success:function(data1)
		      {
				 $("input[type=search]").val("");
			    var data1=JSON.parse(data1);
				
				if(data1.statusCode=="Success")
				{
					for(var i=0; i<markers.length; i++)
					{
						map.removeLayer(markers[i]);
					}
					
					Object.keys( data1 ).forEach(function( key ) {
						
						 if(key!="statusCode")
						 {
							 
							 
						   if(data1[key].current_popularity == null)
						   {
							    var leafletImage = L.icon({
                                iconUrl: "green.png",
                                iconSize: [30, 40],
                                iconAnchor: [15, 40],
                                popupAnchor: [0, -35]
                               });
							
                              function clickZoom(e) 
						      {
							     map.setView(e.target.getLatLng(),15);
                              }
							  
							   var markerid=data1[key].id;
													
						     	marker=L.marker([data1[key].lat,data1[key].lng],{icon: leafletImage});
							
							 
							//if(data1[key].distance<=0.02)
							  //{
								  
								  			    
												 marker.bindPopup("<b>"+ data1[key].name  + "</b><br />Address: "+ data1[key].address + "</b><br />Popularity: " + data1[key].popularity 
															+ "</b><br />AveragePopularity: " +data1[key].averagepopularity+"</b><br />CurrentPopularity: "+data1[key].current_popularity+"%" 
												            +"</b><br  /><input id=current_popularity placeholder=current_popularity  type=number >"
												            +"</b><br  /><input id=spenttime placeholder=spent_time  type=number>"
												            +"</b><br  /><button id=button8>Visit</button>"
												            +"<p id=id2></p>"
												            +"<p id=id3 hidden=yes>"+markerid+"</p>").on("click", clickZoom).addTo(map);
												  
												  marker.on("popupopen",function(){
													  
													  $("#button8").on("click",function(){
														  
														  var current_popularity1=$("#current_popularity").val();
														  var spenttime1=$("#spenttime").val();
                                                          var id1=$("#id3").text();                                                       
														   
														  if(current_popularity1.length!=0 && spenttime1.length!=0 )
														  {
															  if(current_popularity1>=0 && spenttime1>=0)
															  {
															  		  $.ajax({
		                                                                url:"AddVisit.php",
			                                                            type:"POST",
			                                                            data:{
																			  current_popularity:current_popularity1,
																			  spenttime:spenttime1,
																			  id:id1
																		    },
			                                                            cache:false,
																		success:function(data1)
																		{
																			$("#current_popularity").val("");
																			$("#spenttime").val("");
																			
																			var data1=JSON.parse(data1)
																			
																			if(data1.statusCode=="Success" || data1.statusCode=="error1")
																			{
																						$("#id2").text(data1.message);
					                                                                    $("#id2").css("fontSize","15px");
																						
																	
																						var deletemessage=setTimeout(function () {
				  
                                                                                                $("#id2").text("");
				  
		                                                                                    }, 2000);
																						
																			}
																			
																			
																		}
																	})
															  }
															  
														  }
														  
													  })
													  
												  });
												  
												  
								  
								  
							  //}else
							  //{
								  
										  
										 // marker.bindPopup("<b>"+ data1[key].name  + "</b><br />Address: "+ data1[key].address + 
												          //   "</b><br />popularity: "+data1[key].popularity +"</b><br />AveragePopularity: " 
												            // +data1[key].averagepopularity+"</b><br />CurrentPopularity: " + data1[key].current_popularity+"%").on('click', clickZoom).addTo(map);
							       
							  //}
							  
							  markers.push(marker);
							  map.addLayer(marker);
							  

						   }else if(data1[key].current_popularity>0 && data1[key].current_popularity <=32)
						   {
							             var leafletImage = L.icon({
                                            iconUrl: "green.png",
                                            iconSize: [30, 40],
                                            iconAnchor: [15, 40],
                                            popupAnchor: [0, -35]
                                        });
				   
                                      function clickZoom(e) 
				                      {
                                        map.setView(e.target.getLatLng(),15);
                                      }
									  
									   var markerid=data1[key].id;
												
								        marker=L.marker([data1[key].lat,data1[key].lng],{icon: leafletImage});
										
									  
								   //if(data1[key].distance<=0.02)
							       //{
									 
												  marker.bindPopup("<b>"+ data1[key].name  + "</b><br />Address: "+ data1[key].address + "</b><br />Popularity: " + data1[key].popularity 
															+ "</b><br />AveragePopularity: " +data1[key].averagepopularity+"</b><br />CurrentPopularity: "+data1[key].current_popularity+"%" 
												            +"</b><br  /><input id=current_popularity placeholder=current_popularity  type=number >"
												            +"</b><br  /><input id=spenttime placeholder=spent_time  type=number>"
												            +"</b><br  /><button id=button8>Visit</button>"
												            +"<p id=id2></p>"
												            +"<p id=id3 hidden=yes>"+markerid+"</p>").on("click", clickZoom).addTo(map);
												  
												  
												  marker.on("popupopen",function(){
													  
													  $("#button8").on("click",function(){
														  
														  var current_popularity1=$("#current_popularity").val();
														  var spenttime1=$("#spenttime").val();
                                                          var id1=$("#id3").text();
														  
														  if(current_popularity1.length!=0 && spenttime1.length!=0 )
														  {
															  if(current_popularity1>=0 && spenttime1>=0)
															  {
															  		  $.ajax({
		                                                                url:"AddVisit.php",
			                                                            type:"POST",
			                                                            data:{
																			  current_popularity:current_popularity1,
																			  spenttime:spenttime1,
																			  id:id1
																		    },
			                                                            cache:false,
																		success:function(data1)
																		{
																			$("#current_popularity").val("");
																			$("#spenttime").val("");
																			
																			var data1=JSON.parse(data1)
																			
																			if(data1.statusCode=="Success" || data1.statusCode=="error1")
																			{
																						$("#id2").text(data1.message);
					                                                                    $("#id2").css("fontSize","15px");
																	
																						var deletemessage=setTimeout(function () {
				  
                                                                                                $("#id2").text("");
				  
		                                                                                    }, 2000);
																						
																			}
																			
																			
																		}
																	})
															  }
															  
														  }
														  
													  })
													  
												  });
												  
												   
									   
									   
							      //}else
							      //{
								      
							         
									//	 marker.bindPopup("<b>"+ data1[key].name  + "</b><br />Address: "+ data1[key].address + 
										//		             "</b><br />popularity: "+data1[key].popularity +"</b><br />AveragePopularity: " 
											//             +data1[key].averagepopularity+"</b><br />CurrentPopularity: " + data1[key].current_popularity+"%").on('click', clickZoom).addTo(map)
										  
								  
								  //}
								  
								  markers.push(marker);
								  map.addLayer(marker);
							  
	   
							   
						   }else if(data1[key].current_popularity > 32 && data1[key].current_popularity <= 65)
						   {
							                    var leafletImage = L.icon({
                                                 iconUrl: "orange.png",
                                                 iconSize: [30, 40],
                                                 iconAnchor: [15, 40],
                                                 popupAnchor: [0, -35]
                                               });
				
                                           function clickZoom(e) 
				                          {
                                               map.setView(e.target.getLatLng(),15);
                                          }   
										  
										   marker=L.marker([data1[key].lat,data1[key].lng],{icon: leafletImage});
										  
										   var markerid=data1[key].id;
										   
										  
										   if(data1[key].distance<=0.02)
							             {
											 
											 	 
												
								                 
												  
												 marker.bindPopup("<b>"+ data1[key].name  + "</b><br />Address: "+ data1[key].address + "</b><br />Popularity: " + data1[key].popularity 
															+ "</b><br />AveragePopularity: "+data1[key].averagepopularity+ "</b><br />CurrentPopularity: "+data1[key].current_popularity+"%" 
												            +"</b><br  /><input id=current_popularity placeholder=current_popularity  type=number >"
												            +"</b><br  /><input id=spenttime placeholder=spent_time  type=number>"
												            +"</b><br  /><button id=button8>Visit</button>"
												            +"<p id=id2></p>"
												            +"<p id=id3 hidden=yes>"+markerid+"</p>").on("click", clickZoom).addTo(map);
												  
												  marker.on("popupopen",function(){
													  
													  $("#button8").on("click",function(){
														  
														  var current_popularity1=$("#current_popularity").val();
														  var spenttime1=$("#spenttime").val();
														  var id1=$("#id3").text();
														  
														  if(current_popularity1.length!=0 && spenttime1.length!=0 )
														  {
															  if(current_popularity1>=0 && spenttime1>=0)
															  {
															  		  $.ajax({
		                                                                url:"AddVisit.php",
			                                                            type:"POST",
			                                                            data:{
																			  current_popularity:current_popularity1,
																			  spenttime:spenttime1,
																			  id:id1
																		    },
			                                                            cache:false,
																		success:function(data1)
																		{
																			$("#current_popularity").val("");
																			$("#spenttime").val("");
																			
																			var data1=JSON.parse(data1)
																			
																			if(data1.statusCode=="Success" || data1.statusCode=="error1")
																			{
																						$("#id2").text(data1.message);
					                                                                    $("#id2").css("fontSize","15px");
																	
																						var deletemessage=setTimeout(function () {
				  
                                                                                                $("#id2").text("");
				  
		                                                                                    }, 2000);
																						
																			}
																			
																			
																		}
																	})
															  }
															  
														  }
														  
													  })
													  
												  });
												  
												 
											 
							             }else
							             {
								                
											 marker.bindPopup("<b>"+ data1[key].name  + "</b><br />Address: "+ data1[key].address + 
											             "</b><br />popularity: "+data1[key].popularity +"</b><br />AveragePopularity: " 
										             +data1[key].averagepopularity+"</b><br />CurrentPopularity: " + data1[key].current_popularity+"%").on('click', clickZoom).addTo(map)
								     
										}
										
										markers.push(marker);
										map.addLayer(marker);
		  
										         
	  
						   }else 
						   {
							                  var leafletImage = L.icon({
                                                iconUrl: "red.png",
                                                iconSize: [30, 40],
                                                iconAnchor: [15, 40],
                                                popupAnchor: [0, -35]
                                            });
				
                                           function clickZoom(e) {
                                                    map.setView(e.target.getLatLng(),15);
                                            }
											
											
											var markerid=data1[key].id;
											
									       
										   
											marker=L.marker([data1[key].lat,data1[key].lng],{icon: leafletImage});
											
										
											 if(data1[key].distance<=0.02)
							                {
											
											
							
									marker.bindPopup("<b>"+ data1[key].name  + "</b><br />Address: "+ data1[key].address + "</b><br />Popularity: " + data1[key].popularity 
															+ "</b><br />AveragePopularity: " +data1[key].averagepopularity+ "</b><br />CurrentPopularity: "+data1[key].current_popularity+"%" 
												            +"</b><br  /><input id=current_popularity placeholder=current_popularity  type=number >"
												            +"</b><br  /><input id=spenttime placeholder=spent_time  type=number>"
												            +"</b><br  /><button id=button8>Visit</button>"
												            +"<p id=id2></p>"
												            +"<p id=id3 hidden=yes>"+markerid+"</p>").on("click", clickZoom).addTo(map);
									
									 marker.on("popupopen",function(){
													  
													  $("#button8").on("click",function(){
														  
														  var current_popularity1=$("#current_popularity").val();
														  var spenttime1=$("#spenttime").val();
														  var id1=$("#id3").text();
														  
														  if(current_popularity1.length!=0 && spenttime1.length!=0 )
														  {
															  if(current_popularity1>=0 && spenttime1>=0)
															  {
															  		  $.ajax({
		                                                                url:"AddVisit.php",
			                                                            type:"POST",
			                                                            data:{
																			  current_popularity:current_popularity1,
																			  spenttime:spenttime1,
																			  id:id1
																		    },
			                                                            cache:false,
																		success:function(data1)
																		{
																			$("#current_popularity").val("");
																			$("#spenttime").val("");
																			
																			var data1=JSON.parse(data1)
																			
																			if(data1.statusCode=="Success" || data1.statusCode=="error1")
																			{
																						$("#id2").text(data1.message);
					                                                                    $("#id2").css("fontSize","15px");
																	
																						var deletemessage=setTimeout(function () {
				  
                                                                                                $("#id2").text("");
				  
		                                                                                    }, 2000);
																						
																			}
																			
																			
																		}
																	})
															  }
															  
														  }
														  
													  })
													  
												  });
									
									
									
											 
							              }else
							              {
											  
											  
								         marker.bindPopup("<b>"+ data1[key].name  + "</b><br />Address: "+ data1[key].address + 
											             "</b><br />popularity: "+data1[key].popularity +"</b><br />AveragePopularity: " 
										             +data1[key].averagepopularity+"</b><br />CurrentPopularity: " + data1[key].current_popularity+"%").on('click', clickZoom).addTo(map)
										  
										  }
										  
										  markers.push(marker);
										  map.addLayer(marker);
							                
						   }
						   
						 }
                   });
						
						
		  
		}else if(data1.statusCode=="error1")
		{
			$("input[type=search]").val(data1.message);
			
			  var deletemessage=setTimeout(function () {
				  
                  $("input[type=search]").val("").fadeIn('slow');
				  
				  
              }, 3000);
			  
			  $("input[type=search]").on("click",function(){
				  
				  clearTimeout(deletemessage); 
                     
             });
			  
		}
				
	   }
		
	      });
	 }
	
     
  });
	
		
	$("#button3").on("click",function(){
		
		if($("#flip1").is(":hidden") &&($("input[type=date]").val().length!=0))		
		{
			$("input[type=date]").val("");
			
		}
		
		if($("#button7").is(":hidden"))
		{
				$("#button7").show();
		}else
		{
				setTimeout(function(){
					
					
					$("#button7").hide();
					
					
				},280);
		}
				
		
		$("#flip1").slideToggle("slow");
		
	});
	
	
	$("#button4").on("click",function(){
		
			window.location.href="printcases.php";	
	});
	
	$("#button5").on("click",function(){
		window.location.href="Profile.php";
	});
	
	$("#button6").on("click",function(){
		
		$.ajax({
		 url:"../logout.php",
		 
		 success:function(data1)
		  {
			var data1=JSON.parse(data1);
			
			window.location.href=data1.url;
		  }
		
			
		});
		
	});
	
	
	$("#button7").on("click",function(){
		
		var date1 =$("#date1").val();
		
		if(date1.length!=0)
		{
			
		  $.ajax({
		    url:"AddCases.php",
			type:"POST",
			data:
			{
				date:date1
			},
			cache:false,
		 
		    success:function(data1)
		     {
				 
			   $("input[type=date]").val("");
               				
			    var data1=JSON.parse(data1);
				
				if(data1.statusCode=="Success" || data1.statusCode=="error1")
				{
					$("#id1").text(data1.message);
					$("#id1").css("fontSize","15px");
					
					var deletemessage=setTimeout(function () {
				  
                      $("#id1").text("");
				  
		             }, 3000);
					
						
				}
				
		     }
			
		    });
		}
		
	});
	
	
	$("#button9").on("click",function(){
		
		$("#flip1").hide();
		
		if ($(window).width() <=600)
		{
		
			$(".sidebar").animate({width: "toggle"}, 500);
			$("#map").animate({marginLeft: "11%"},500);
			$(".smallsidebar").animate({width:"toggle"},100);
		}
			
		if(($(window).width()>=601) && ($(window).width()<=1999))
		{
					
			$(".sidebar").animate({width: "toggle"}, 500);
			$("#map").animate({marginLeft: "9%"},500);
			$(".smallsidebar").animate({width:"toggle"},100);
		}
	});
	
	$("#button10").on("click",function(){
		
		if ($(window).width() <=600)
		{
		
			$(".sidebar").animate({width: "toggle"}, 100);
			$("#map").animate({marginLeft: "47%"},500);
			$(".smallsidebar").animate({width:"toggle"},100);
		}
			
		if(($(window).width()>=601) && ($(window).width()<=1999))
		{
			$(".sidebar").animate({width: "toggle"}, 100);
			$("#map").animate({marginLeft: "30%"},500);
			$(".smallsidebar").animate({width:"toggle"},100);
		}
	});
	 
});
