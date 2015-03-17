/**
 * @author mk
 */

var j=jQuery;
var Ax={}




///////////////////////////////////////////////////////////////namespaced functions////////////////////////////////////////////////////////////////////// 

/////lightbox function. Made fairly generic to lightbox almost everything. 
Ax["lightBox"] = function(toAttach)
{
	j('header').before('<div class="blanket"><a href="#" class="close">Close</a></div>');
	j(toAttach).appendTo('.blanket');
	j('.blanket:last').fadeIn();
};





/////load classes on Student.php page load  (or click on Load/Load more)
Ax["successJSON_loadCourseTable"] = function(data)
{ 
		Ax["data"] = j.parseJSON(data);
		
		var ct= j.parseJSON(data).length;
		
		for(var i=0; i<ct; i++)
		{
			//merging all prerequisites into one string with conditions
			var prereq = (Ax.data[i].course_Prerequisite1) ? ( Ax.data[i].course_Prerequisite1) : "NIL" ;
			    prereq +=(Ax.data[i].course_Prerequisite2) ? (", "+ Ax.data[i].course_Prerequisite2) : "" ;
				prereq +=(Ax.data[i].course_Prerequisite3) ? (", "+ Ax.data[i].course_Prerequisite3) : "" ;
				prereq +=(Ax.data[i].course_Prerequisite4) ? (", "+ Ax.data[i].course_Prerequisite4) : "" ;
				prereq +=(Ax.data[i].course_Prerequisite5) ? (", "+ Ax.data[i].course_Prerequisite5) : "" ;
			
			j('<tr>   <td>'+Ax.data[i].current_courses+'</td>  <td>'+Ax.data[i].course_name+'</td>  <td>'+Ax.data[i].course_credit+'</td>  <td>'+Ax.data[i].course_Session+'</td>  <td>'+prereq+'</td>   </tr>').appendTo('#scheduler');
			
		}
		
	};

	
	
	
	
/////show sections in a popup, Ax.loadSections() success function.	
Ax["successSection"] = function(data)
{
	//If you want to view the raw data, uncomment the line below! (Spoiler alert! It's SUPER ugly.) 
	//j('#temp').html(data);
	
	Ax["sectionData"] = j.parseJSON(data);
	var ct = Ax.sectionData.length;
	//setting fixed height in case of screen overflow.
	var cutoffHeight = ( (j(window).height()-60)*0.8 > ct*40 ) ? ("auto") : ((j(window).height()-60)*0.8 + "px");
	//table construction
	
	
	var toSend = '<div class="sectionsWrapper" style="height:'+cutoffHeight+'"><table class="sectionsTable"><tr class="tableHeader"> <th>Section Name</th> <th>Course ID</th> <th>Faculty</th> <th>Session</th>  <th>Room</th> <th>Tutorial</th> <th>Lab</th>  </tr>';
		
		if(ct==0)
			toSend+='<tr class="noClick"><td colspan="8" class="noClick">No section available</td></tr>';
		else
		for(var i=0; i<ct; i++)
		{
			
			var ClassSession = Ax.sectionData[i].class_day +"\t"+ Ax.sectionData[i].class_start+" - "+ Ax.sectionData[i].class_end;
			var ClassRoom = Ax.sectionData[i].class_building + Ax.sectionData[i].class_room;
			var Tutotial = (Ax.sectionData[i].class_tutorial_code) ? (Ax.sectionData[i].class_tutorial_code + "\n" +
																	  Ax.sectionData[i].class_tutorial_day + "\t" +
																	  Ax.sectionData[i].class_tutorial_start + " - " +
																	  Ax.sectionData[i].class_tutorial_end + "\n" +
																	  Ax.sectionData[i].class_tutorial_room +
																	  Ax.sectionData[i].class_tutorial_building) : "NIL";
			
			var Lab = (Ax.sectionData[i].class_lab_code) ? (Ax.sectionData[i].class_lab_code + "\n"+
															Ax.sectionData[i].class_lab_day + "\t"+
															Ax.sectionData[i].class_lab_start + " - "+
															Ax.sectionData[i].class_lab_end + "\n"+
															Ax.sectionData[i].class_lab_room + 
															Ax.sectionData[i].class_lab_building) : "NIL";
			
			
			toSend+= '<tr>  <td>'+Ax.sectionData[i].current_classes+'</td>  <td>'+Ax.sectionData[i].course_name+'</td>  <td>'
								 +Ax.sectionData[i].class_teacher+'</td>  <td>'+ClassSession+'</td>  <td>'+ClassRoom+'</td> <td>'
								 +Tutotial+'</td> <td>'+Lab+'</td>  </tr>';
		}
		
		Ax.lightBox(toSend+'</table></div>');
}





//parsing current courses function. Ax.updateClassesTaken() success function.
Ax["currentCourses"] = function(data)
{

	if(data == "No classes")
	{

		if(j('#tableClassesSelected tr').length == 2) 
			j('#tableClassesSelected tr:eq(1)').html('<td colspan="8">No class taken</td>'); 
		else 
			j('<tr><td colspan="8">No class taken</td></tr>').appendTo('#tableClassesSelected');
	}
	else
	{
		var toSend ='<tr class="tableHeader"> <th>Section Name</th>  <th>Course ID</th> <th>Faculty</th> <th>Session</th> <th>Room</th> <th>Tutorial</th> <th colspan="2">Lab</th> </tr>';
		try
		{
			Ax["takenClass"] = j.parseJSON(data);
		}
		catch(err)
		{
			//alert(err);
			var errDiv = document.createElement("div");
			errDiv.innerHTML=data;
			var child = document.getElementById('temp');
			child.parentNode.insertBefore(errDiv, child);
			//window.location = window.location  //temporary stub to counter bug. JS page reload. :p
		}

		Ax["takenClass"] = j.parseJSON(data);
		var ct = Ax.takenClass.length;

		if(ct==0)
			toSend+='<tr><td colspan="8">No class taken</td></tr>';
		else
		for(var i=0; i<ct; i++)
		{
			var ClassSession = Ax.takenClass[i].class_day +"\t"+ Ax.takenClass[i].class_start+" - "+ Ax.takenClass[i].class_end;
			var ClassRoom = Ax.takenClass[i].class_building + Ax.takenClass[i].class_room;
			var Tutotial = (Ax.takenClass[i].class_tutorial_code) ? (Ax.takenClass[i].class_tutorial_code + "\n" +
																	  Ax.takenClass[i].class_tutorial_day + "\t" +
																	  Ax.takenClass[i].class_tutorial_start + " - " +
																	  Ax.takenClass[i].class_tutorial_end + "\n" +
																	  Ax.takenClass[i].class_tutorial_room +
																	  Ax.takenClass[i].class_tutorial_building) : "NIL";
			
			var Lab = (Ax.takenClass[i].class_lab_code) ? (Ax.takenClass[i].class_lab_code + "\n"+
															Ax.takenClass[i].class_lab_day + "\t"+
															Ax.takenClass[i].class_lab_start + " - "+
															Ax.takenClass[i].class_lab_end + "\n"+
															Ax.takenClass[i].class_lab_room + 
															Ax.takenClass[i].class_lab_building) : "NIL";
			
			
			toSend+= '<tr>  <td>'+Ax.takenClass[i].current_classes+'</td>  <td>'+Ax.takenClass[i].course_name+'</td>  <td>'
								 +Ax.takenClass[i].class_teacher+'</td>  <td>'+ClassSession+'</td>  <td>'+ClassRoom+'</td> <td>'
								 +Tutotial+'</td> <td>'+Lab+'</td> <td class="removeCourse">Remove</td>  </tr>';
		}


		j('#tableClassesSelected').html(toSend+'</table>');	
	}
}




//CURRENT courses list load function. (Courses taken)
Ax["updateClassesTaken"]=function()
{
			j.ajax({
			type:'GET',
			datatype:'JSON',
			url:'currentClasses.php',
			success: Ax.currentCourses,
			error:function(xhr, ajaxOptions, thrownError){alert(xhr.status+"\n"+thrownError);}
		});
}




//ALL courses list load function
Ax["loadClasses"] = function(){	
	j.ajax({
		type:'GET',
		datatype:'JSON',
		url:'scheduler.php',
		success: Ax.successJSON_loadCourseTable,
		//success : function(data){ j('#temp').html(data); },
		error:function(xhr, ajaxOptions, thrownError){alert(xhr.status+"\n"+thrownError);}
	});
}



//Clicked class' section data load function
Ax["loadSections"]=function(clickedCourse){
		j.ajax({
		type:'POST',
		url:'sectionPick.php',
		data:{CourseID : clickedCourse},
		cache: false,
		success: Ax.successSection,
		error: function(xhr, ajaxOptions, thrownError){alert(xhr.status+"\n"+thrownError);}
	});
}


///////////////////////////////////////////////////////////////DOM Manipulation below////////////////////////////////////////////////////////////////////// 
j(function(){
	//loading ALL courses list
	Ax.loadClasses();
	
	//loading CURRENT courses list. (Courses taken)
	Ax.updateClassesTaken();

	

/*	j('#loadMore').click(function(ev)   /////////commented out section, changes functionality; the table now loads on page load, not on Load-click.
	{
		ev.preventDefault();
		Ax.loadClasses();
	}); 
*/
	
	//Section table loading code code below. 
	j(document).on('click','#scheduler td:not(#loadMore)',function(ev)
	{
		var clickedCourse = j(this).parent().children().eq(0).text();
		
		//load section data into popup.
		Ax.loadSections(clickedCourse);
	});
	
	j(document).on('click','.close',function(ev)
	{
		ev.preventDefault();
		j('.blanket').fadeOut('normal',function(){j('.blanket').remove();});
	});
	
	//section selection recording below
	j(document).on('click','.sectionsTable td:not(.tableHeader, .noClick)', function(ev){
		
		var section = j(this).parent().children().eq(0).text();
		var course = j(this).parent().children().eq(1).text();
		
		j.ajax({
			type:'POST',
			url:'sectionSelect.php',
			data:{'classid' : section, 'courseid':course },
			cache: false,
			success : function(data){ 
									Ax.updateClassesTaken();
									j('.close').css('color','#1f766b').html(data);
									Ax["blanketTimeout"] = setTimeout(function(){j('.blanket').fadeOut('normal',function(){j('.blanket').remove();})} , 2000);
								},
			error: function(xhr, ajaxOptions, thrownError){alert(xhr.status+"\n"+thrownError);}
		});
		
	});
	
	//section recording removal below
	j(document).on('click','.removeCourse', function(ev){
		
		var section = j(this).parent().children().eq(0).text();
		var course = j(this).parent().children().eq(1).text();
		
		j.ajax({
			type:'POST',
			url:'sectionRemove.php',
			data:{'classid' : section, 'courseid':course },
			cache: false,
			success : function(data){ 
										Ax.currentCourses(data); 
										j('#temp').html('Course removed'); 
										setTimeout(function(){j('#temp').html('')},2000);
									},
			error: function(xhr, ajaxOptions, thrownError){alert(xhr.status+"\n"+thrownError);}
		});
		
	});
	
	
	
	
	
});
