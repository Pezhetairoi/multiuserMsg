/**
 * 
 */
 window.onload = function(){
 	passcode();
 	
 	var form = document.getElementsByTagName('form')[0];
 	form.onsubmit = function(){
 		//passcode
		if(form.passcode.value.length != 4){
			alert('Passcode must be 4 characters long!');
			form.email.value=""; //clear field
			form.email.focus(); //focus on username field
			return false;
		}
		
		//content
		if(form.content.value.length < 2 || form.content.value.length > 200){
			alert('Text must between 2 - 200 characters.');
			form.content.focus();
			return false;
		}
 	}
 }