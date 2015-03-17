/**
 * @author mk
 */

var j=jQuery;
var Ax={}




///////////////////////////////////////////////////////////////namespaced functions////////////////////////////////////////////////////////////////////// 


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
		var toSend ='<tr class="tableHeader"> <th>Section Name</th>  <th>Course ID</th>  <th>Session</th> <th>Room</th> <th>Tutorial</th> <th colspan="2">Lab</th> </tr>';
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
			return false;

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
			
			
			toSend+= '<tr>  <td>'+Ax.takenClass[i].current_classes+'</td>  <td>'+Ax.takenClass[i].course_name+'</td> <td>'+ClassSession+'</td>  <td>'+ClassRoom+'</td> <td>'
								 +Tutotial+'</td> <td>'+Lab+'</td></tr>';
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

///////////////////////////////////////////////////////////////DOM Manipulation below////////////////////////////////////////////////////////////////////// 
j(function(){

	//loading CURRENT courses list. (Courses taken)
	Ax.updateClassesTaken();
	
});
