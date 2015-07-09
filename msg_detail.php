<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 8 Jul 2015
*/
session_start();
//define a constant to authorize the access to inc.php
define('HF', true);

//define a constant to specify the css of the current page
define('SCRIPT','msg_detail');

require dirname(__FILE__).'/includes/common.inc.php';

//check if user has signed in
if(!isset($_COOKIE["username"])){
    alert_close("Please sign in first.");
}
//check if delete action is executed
if(isset($_GET["action"])=="delete" && isset($_GET["id"])){
    $sql = "SELECT tg_id
    FROM tg_msg
    WHERE tg_id = '{$_GET["id"]}' LIMIT 1";
    $result = $conn->query($sql) or die($conn->error);
    
    if(!!$row = $result->fetch_assoc()){
        
        
        //check if cookie exists
        $result2 = $conn->query("SELECT tg_uniqid
            FROM tg_guest
            WHERE tg_username = '{$_COOKIE["username"]}'");
        
        if(!!$row2 = $result2->fetch_assoc()){       
            //check if uniqid matches
            //call matchUniqid
            matchUniqid($row2["tg_uniqid"], $_COOKIE["uniqid"]);
            
            //exec delete
            $conn->query("DELETE FROM tg_msg 
                            WHERE tg_id = '{$_GET["id"]}' LIMIT 1
                          ");
             if($conn->affected_rows == 1){
                $conn->close();
                session_destroy();
                location("Delete successful !", "check_msg.php");
             }else{
                $conn->close();
                session_destroy();
                alert_return("Delete failed.");
             }
        }
    }else{
        alert_return("Cannot delete");
    } 
}

//check if id exists
if(isset($_GET["id"])){
    $sql = "SELECT tg_id, tg_state, tg_fromuser, tg_content, tg_date
    FROM tg_msg
    WHERE tg_id = '{$_GET["id"]}'";
    $result = $conn->query($sql) or die($conn->error);
    
    if(!!$row = $result->fetch_assoc()){
        if(empty($row["tg_state"])){
            $conn->query("UPDATE tg_msg
                          SET tg_state = 1
                          WHERE tg_id = '{$_GET["id"]}'");
        }
        if(!$conn->affected_rows){
            alert_return("Exception found.");
        }
        $msg_details = array();
        $msg_details["id"] = $row["tg_id"];
        $msg_details["fromuser"] = $row["tg_fromuser"];
        $msg_details["content"] = $row["tg_content"];
        $msg_details["date"] = $row["tg_date"];
        $msg_details = htmlFilter($msg_details);
        
    }else{
        alert_return("Message does not exist.");
    }
}else{
    alert_return("Please sign in first.");
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php 
    require "includes/title.inc.php";
?>
<script type="text/javascript" src="js/delete_msg.js"></script>
<title>Insert title here</title>
</head>
    <body>
    <?php
    //include header
    require ROOT_PATH.'includes/header.inc.php';
    
    //include setting sidebar
    require ROOT_PATH.'includes/settings.inc.php';
    ?>
   
   <div id="settings_main">
        <h2>Message Details</h2>
        <dl>
            <dd>Sender:<p><?php echo $msg_details["fromuser"] ?></p></dd>
            <dd>Content:<p><?php echo $msg_details["content"] ?></p></dd>
            <dd>Sent at: <p><?php echo $msg_details["date"] ?></p></dd>
            <input type="button" value="Return" id="return" />
            <input type="button" value="Delete" id="delete" name="<?php echo $msg_details["id"] ?>"/>
        </dl>
   </div>
   
    <?php
    //include footer 
    require ROOT_PATH.'includes/footer.inc.php';
    ?>  
    </body>
</html>