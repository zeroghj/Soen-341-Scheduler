/*
* author MK
*/

var j=jQuery;
var PW = {};

j(function(){
	j('#oldPassword').focusout(function(){
		PW['oldPassword'] = j(this).val().trim();

		if(PW.oldPassword == '')
			j(this).next('.errorSpace').text('Required!');
		else
			j(this).next('.errorSpace').text('');
	});


	j('#newPassword').focusout(function(){
		PW['newPassword'] = j(this).val().trim();
		if(PW.newPassword == '')
			j(this).next('.errorSpace').text('Required!');
		else
			j(this).next('.errorSpace').text('');
	});


	j('#confirmPassword').focusout(function(){
		PW['confirmPassword'] = j(this).val().trim();
		
		if(PW.newPassword!=PW.confirmPassword)
			j(this).next('.errorSpace').text('Passwords do not match!');
		else
			j(this).next('.errorSpace').text('');	
	});


	j(document).on('click','#PWsubmit', function(ev){
		ev.preventDefault();
		var testString = "";
		j.each(j('.errorSpace'), function(ind, errorObj)
		{
			testString += j(this).text(); 
		});

		if(testString.length==0)
		{
			//j(this).off('click').click();
		}

	});

});