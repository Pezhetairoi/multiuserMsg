/**
 * 
 */
 window.onload = function (){
 	var img = document.getElementsByTagName('img');	
 	for(i=0; i<img.length; i++){
 		img[i].onclick = function(){
 			popup(this.alt);
 		};
 	}
 };

function popup(alt){
	var img = opener.document.getElementById('avaimg');
	img.src = alt;
	opener.document.register.imgalt.value = alt;
}