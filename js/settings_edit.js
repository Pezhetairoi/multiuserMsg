/**
 * 
 */
 window.onload = function(){
 	passcode();
 	
 	var form = document.getElementsByTagName("form")[0];
 	form.onsubmit = function(){
 		if(form.password.value !=""){
	 		if(form.password.value.length < 6){
				alert('Password length must be at least 6 characters long.');
				form.password.value=""; //clear field
				form.password.focus(); //focus on field
				return false;
			}
 		}
		//email
		if(!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(form.email.value)){
			alert('Invalid Email address!');
			form.email.value=""; //clear field
			form.email.focus(); //focus on username field
			return false;
		}
		
		//passcode
		if(form.passcode.value.length != 4){
			alert('Passcode must be 4 characters long!');
			form.email.value=""; //clear field
			form.email.focus(); //focus on username field
			return false;
		}
		return true;
 	}
 }
 	