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
define('SCRIPT','addfriend');

require dirname(__FILE__).'/includes/common.inc.php';

//check if user has signed in
if(!isset($_COOKIE["username"])){
    alert_close("Please sign in first.");
}

//add friend
if(isset($_GET["action"]) && $_GET["action"] == "add"){
    
    $result = $conn->query("SELECT tg_uniqid 
                            FROM tg_guest 
                            WHERE tg_username = '{$_COOKIE["username"]}'");
    
    //check if uniqid matches
    if(!!$row = $result->fetch_assoc()){
    
        //call matchUniqid
        matchUniqid($row["tg_uniqid"], $_COOKIE["uniqid"]);
    
        include ROOT_PATH."includes/check.func.php";
        
        $addfriend = array();
        $addfriend["touser"] = mysqli_real_escape_string($conn, $_POST["touser"]);
        $addfriend["fromuser"] = mysqli_real_escape_string($conn, $_COOKIE["username"]);
        $addfriend["content"] = checkContent(mysqli_real_escape_string($conn, $_POST["content"]));
        //cannot add user himself
        if($addfriend["touser"] == $addfriend["fromuser"]){
            alert_close("You cannot add yourself.");
        }
        
        //check if the user is already a friend
        $result2 = $conn->query("SELECT tg_id
                                FROM tg_friend
                                WHERE 
                                (tg_touser='{$addfriend["touser"]}' AND tg_fromuser='{$addfriend["fromuser"]}')
                                OR
                                (tg_touser='{$addfriend["fromuser"]}' AND tg_fromuser='{$addfriend["touser"]}')
                                ");
        if(!!$row2 = $result2->fetch_assoc()){
            alert_close("You are already friends");
        }else{
            //exec add friend operation
            $result3 = $conn->query("INSERT INTO tg_friend
                                        (tg_touser, tg_fromuser, tg_content, tg_date)
                                     VALUES 
                                        ('{$addfriend["touser"]}',
                                         '{$addfriend["fromuser"]}',
                                         '{$addfriend["content"]}',
                                         NOW())   
                                         ") or die($conn->error);
        }
        
        if($conn->affected_rows == 1){
            $conn->close();
            session_destroy();
            alert_close("Friend request sent await for approval.");
        }else{
            $conn->close();
            session_destroy();
            alert_return("Failed to send friend request");
        }
    }
}

//retrieve specific user
if(isset($_GET["id"])){
    $sql = "SELECT tg_username 
            FROM tg_guest 
            WHERE tg_id='{$_GET["id"]}'";
    
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
<title>Add Friend</title>
</head>
    <body>
   <div id="msg">
    <h3>Write message</h3>
    <form method="post" action="addfriend.php?action=add">
    <input type="hidden" name="touser" value="<?php echo $html["touser"] ?>" />
    <dl>
        <dd><input type="text" class="text" readonly = "readonly" value="TO: <?php echo $html["touser"] ?>"/></dd>
        <dd><textarea name="content">I would like to add you as my friend.</textarea></dd>
        <dd><label>Passcode</label><input type="text" name="passcode" class="passcode" />
                                        <img src="code.php" id="code" />
                                        <input type="submit" class="submit" value="Add Friend" />
                                        </dd>
    </dl>
    </form>
   </div>
    </body>
</html>