/**
 * 
 */
window.onload = function(){
	var avaimg = document.getElementById('avaimg');
	avaimg.onclick = function(){
		window.open('avatar.php', 'avatar','width=600, height=400,top=0,left=0, scrollbars=1;');
	}
	
	//generate passcode
	passcode();
	
	//form validation
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
		
		//confirm password
		if(form.password.value != form.notpassword.value){
			alert('Password does not match!');
			form.notpassword.value=""; //clear field
			form.notpassword.focus(); //focus on username field
			return false;
		}
		
		//hint
		if(form.passhint.value.length < 6 || form.passhint.value.length > 20){
			alert('Password Hint length must be 6-20 characters long.');
			form.passhint.value=""; //clear field
			form.passhint.focus(); //focus on username field
			return false;
		}
		//ans
		if(form.passans.value.length < 3 || form.passans.value.length > 20){
			alert('Password Answer length must be 6-20 characters long.');
			form.passans.value=""; //clear field
			form.passans.focus(); //focus on username field
			return false;
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
};