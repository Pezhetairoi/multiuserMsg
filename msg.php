<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 7 Jul 2015
*/
session_start();

define('HF', true);

//define a constant to specify the css of the current page
define('SCRIPT','msg');

require dirname(__FILE__).'/includes/common.inc.php';

//check if user has signed in
if(!isset($_COOKIE["username"])){
    alert_close("Please sign in first.");
}

//send text 
if(isset($_GET["action"]) && $_GET["action"] == "send"){
    //varify passcode
    checkCode($_POST["passcode"], $_SESSION["code"]);
    
    $result = $conn->query("SELECT tg_uniqid FROM tg_guest WHERE tg_username = '{$_COOKIE["username"]}'");
    
    //check if uniqid matches
    if(!!$row = $result->fetch_assoc()){
    
        //call matchUniqid
        matchUniqid($row["tg_uniqid"], $_COOKIE["uniqid"]);
        
        include ROOT_PATH."includes/check.func.php"; 
        
        $sendmsg = array();
        $sendmsg["touser"] = mysqli_real_escape_string($conn, $_POST["touser"]);
        $sendmsg["fromuser"] = mysqli_real_escape_string($conn, $_COOKIE["username"]);
        $sendmsg["content"] = checkContent(mysqli_real_escape_string($conn, $_POST["content"]));
        //cannot add user himself
        if($sendmsg["touser"] == $sendmsg["fromuser"]){
            alert_close("You cannot send message to yourself.");
        }
        //write into db
        $result2 = $conn->query("INSERT INTO tg_msg (
                                    tg_touser,
                                    tg_fromuser,
                                    tg_content,
                                    tg_date
                                
                                ) VALUES(
                                    '{$sendmsg["touser"]}',
                                    '{$sendmsg["fromuser"]}',
                                    '{$sendmsg["content"]}',
                                    NOW()
                                )");
        
        if($conn->affected_rows == 1){
            $conn->close();
            session_destroy();
            alert_close("Text sent.");
        }else{
            $conn->close();
            session_destroy();
            alert_return("Text sent failure.");  
        }
    }
}

//retrieve specific user
if(isset($_GET["id"])){
    $sql = "SELECT tg_username FROM tg_guest WHERE tg_id='{$_GET["id"]}'";
    $result = $conn->query($sql) or die($conn->error);

    if(!!$row = $result->fetch_assoc()){
        $html = array();
        $html["touser"] = $row["tg_username"];
        $html = htmlFilter($html);
        
    }else{
        alert_close("Username does not exist.");
    }
}else{
    alert_return("Illegal Operation.");
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

<script type="text/javascript" src="js/passcode.js"></script>
<script type="text/javascript" src="js/msg.js"></script>
<title>Insert title here</title>
</head>
    <body>
   <div id="msg">
    <h3>Write message</h3>
    <form method="post" action="msg.php?action=send">
    <input type="hidden" name="touser" value="<?php echo $html["touser"] ?>" />
    <dl>
        <dd><input type="text" class="text" readonly = "readonly" value="TO: <?php echo $html["touser"] ?>"/></dd>
        <dd><textarea name="content"></textarea></dd>
        <dd><label>Passcode</label><input type="text" name="passcode" class="passcode" />
                                        <img src="code.php" id="code" />
                                        <input type="submit" class="submit" value="Submit" />
                                        </dd>
    </dl>
    </form>
   </div>
    </body>
</html>