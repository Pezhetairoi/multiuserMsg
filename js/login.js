/**
 * 
 */
 
 window.onload = function(){
	
	passcode();
	
	//form validate
	var form = document.getElementsByTagName('form')[0];
	form.onsubmit = function(){
		if(form.username.value.length < 3 || form.username.value.length > 20){
			alert('Username length must be 3-20 characters long.');
			form.username.value=""; //clear field
			form.username.focus(); //focus on username field
			return false;
		}
		if(/<>\'\"\ /.test(form.username.value)){
			alert('Username contains invalid characters!');
			form.username.value=""; //clear field
			form.username.focus(); //focus on username field
			return false;
		}
		//password 
		if(form.password.value.length < 6){
			alert('Password length must be at least 6 characters long.');
			//document.getElementById("username_err").innerHTML('Password length must be at least 6 characters long.');
			//document.getElementById("username_err").style.color = 'red';
			form.password.value=""; //clear field
			form.password.focus(); //focus on field
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