/**
 * 
 */
 window.onload = function(){
 	passcode();
 	
 	var ubb = document.getElementById("ubb");
 	var ubbimg = ubb.getElementsByTagName("img");
 	var form = document.getElementsByTagName("form")[0];
 	
 	ubbimg[0].onclick = function(){
 		// font size
 	}
 	
 	ubbimg[2].onclick = function(){
 		content("[b][/b]");
 	}
 	
 	ubbimg[3].onclick = function(){
 		content("[i][/i]");
 	}
 	
 	ubbimg[4].onclick = function(){
 		content("[u][/u]");
 	}
 	
 	ubbimg[5].onclick = function(){
 		content("[s][/s]");
 	}
 	
 	ubbimg[8].onclick = function(){
 		var url = prompt("Enter URL", " http://");
 		if(url){
 			if(/^http?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(url)){
 				content('[url]'+url+'[/url]');
 			}else{
 				alert("Invalid URL");
 			}
 		}	
 	}
 	
 	ubbimg[9].onclick = function(){
 		var email = prompt("Enter URL", "");
 		if(email){
 			if(!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(form.email.value)){
 				content('[email]'+email+'[/email]');
 			}else{
 				alert("Invalid Email");
 			}
 		}	
 	}
 	ubbimg[10].onclick = function(){
 		var img = prompt("Enter image location", "@");
 		content('[img]'+img+'[img]');
 	}
 	function content(str){
 		form.content.value += str;
 	}
 }