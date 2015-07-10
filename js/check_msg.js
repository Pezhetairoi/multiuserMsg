/**
 * 
 */
 window.onload = function(){
 	var checkall = document.getElementById("checkall");
 	var form = document.getElementsByTagName("form")[0];
 	checkall.onclick = function(){
 		for(var i=0; i< form.elements.length; i++){
 			if(form.elements[i].name != "checkall"){
 				form.elements[i].checked = form.checkall.checked;
 			}
 		}
 	};
 	
 	form.onsubmit = function(){
 		if(confirm("Do you want to delete these entries?")){
 			return true;
 		}
 		return false;
 	}
 };