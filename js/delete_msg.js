/**
 * 
 */
 window.onload = function(){
 	var ret = document.getElementById("return");
 	var del = document.getElementById("delete");
 	
 	ret.onclick = function(){
 		history.back();
 	}
 	
 	del.onclick = function(){
 		if(window.confirm("Do you want to delete this message?")){
 			location.href="msg_detail.php?action=delete&id="+this.name;
 		}
 	}
 }