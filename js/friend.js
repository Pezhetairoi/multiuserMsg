/**
 * 
 */
 window.onload = function(){
 	var msg = document.getElementsByName('msg');
 	var addfriend= document.getElementsByName('addfriend');
 	var sendstar = document.getElementsByName('sendstar');
 	for(var i=0; i<msg.length; i++){
 		msg[i].onclick = function(){
 			centerWindow('msg.php?id='+this.title, 'Message', 250, 500);
 		}
 	}
 	for(var i=0; i<addfriend.length; i++){
 		addfriend[i].onclick = function(){
 			centerWindow('addfriend.php?id='+this.title, 'Add Friend', 250, 500);
 		}
 	}
 	
 	for(var i=0; i<sendstar.length; i++){
 		sendstar[i].onclick = function(){
 			centerWindow('sendstar.php?id='+this.title, 'Send Star', 250, 500);
 		}
 	}
 };
 
function centerWindow(url, name, height, width){
	var top = (screen.height - height) / 2;
	var left = (screen.width - width) / 2;
	window.open(url, name, 'height='+height+',width='+width+',top='+top+',left='+left);
}