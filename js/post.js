/**
 * 
 */
 window.onload = function(){
 	passcode();
 	
 	var ubb = document.getElementById("ubb");
 	var ubbimg = ubb.getElementsByTagName("img");
 	var form = document.getElementsByTagName("form")[0];
 	var font = document.getElementById("font");
 	var html = document.getElementsByTagName("html")[0];
 	var color = document.getElementById("color");
 	
 	html.onmouseup = function(){
 		font.style.display = "none";
 		color.style.display = "none";	
 	}
 	
 	ubbimg[0].onclick = function(){
 		font.style.display = "block";
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
 	ubbimg[7].onclick = function(){
 		color.style.display = "block";
 		form.inp.focus(); 
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
 
 function font(size){
 	document.getElementsByTagName("form")[0].content.value += "[size=" + size + "][/size]";
 }
 function showcolor(value){
 	document.getElementsByTagName("form")[0].content.value += "[color=" + value + "][/color]";
 	
 }
 