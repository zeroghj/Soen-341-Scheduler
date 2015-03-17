/**
 * @author mk
 */

var j=jQuery;
var SP = {};


j(function(){

////checkbox error checking 
j(document).on('click','#pickDays input',function(ev){

SP["checkboxDays"]="";

j('#pickDays input').each(function(index){
	SP.checkboxDays += j(this).is(':checked') ? j(this).val() : "" ;
});

if(SP.checkboxDays.length <= 0)
	{
		ev.preventDefault();
		j('#courseErrorSpace').text("At least one day of the week must be picked.");
	}
else
	j('#courseErrorSpace').html("");
});


////Time of the day error checking timeTo

j(document).on('change','#timeTo,#timeFrom',function(ev){
	
	SP["timeFrom"] = parseInt(  j('#timeFrom option:selected').attr('value').split(":")[0]  );
	SP["timeTo"] = parseInt(  j('#timeTo option:selected').attr('value').split(":")[0]  );
	
	//alert("from:"+SP.timeFrom+"\nto:"+SP.timeTo);
	if(SP.timeFrom > SP.timeTo || SP.timeFrom == SP.timeTo)
		{
			j('#courseErrorSpace').text("Invalid time-range; entire 24 hours will be considered if left unchanged");
			$('#timeFrom option:first').attr('selected', true);
			$('#timeTo option:last').attr('selected', true);
		}
	else
		j('#courseErrorSpace').html("");
});


});