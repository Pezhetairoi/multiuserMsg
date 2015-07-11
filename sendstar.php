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
define('SCRIPT','sendstar');

require dirname(__FILE__).'/includes/common.inc.php';

//check if user has signed in
if(!isset($_COOKIE["username"])){
    alert_close("Please sign in first.");
}

//send star
if(isset($_GET["action"]) && $_GET["action"] == "send"){
    
    $result = $conn->query("SELECT tg_uniqid 
                            FROM tg_guest 
                            WHERE tg_username = '{$_COOKIE["username"]}'");
    
    //check if uniqid matches
    if(!!$row = $result->fetch_assoc()){
    
        //call matchUniqid
        matchUniqid($row["tg_uniqid"], $_COOKIE["uniqid"]);
    
        include ROOT_PATH."includes/check.func.php";
        
        $sendstar = array();
        $sendstar["touser"] = mysqli_real_escape_string($conn, $_POST["touser"]);
        $sendstar["fromuser"] = mysqli_real_escape_string($conn, $_COOKIE["username"]);
        $sendstar["star"] = $_POST["star"];
        $sendstar["content"] = checkContent(mysqli_real_escape_string($conn, $_POST["content"]));
        //cannot add user himself
        if($sendstar["touser"] == $sendstar["fromuser"]){
            alert_close("You cannot send stars to yourself");
        }
            //exec send star
            $result2 = $conn->query("INSERT INTO tg_star
                                        (tg_touser, tg_fromuser, tg_star, tg_content, tg_date)
                                     VALUES 
                                        ('{$sendstar["touser"]}',
                                         '{$sendstar["fromuser"]}',
                                         '{$sendstar["star"]}',
                                         '{$sendstar["content"]}',
                                         NOW())   
                                         ") or die($conn->error);
        
        if($conn->affected_rows == 1){
            $conn->close();
            session_destroy();
            alert_close("Star sent.");
        }else{
            $conn->close();
            session_destroy();
            alert_return("Failed to send star.");
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
<title>Send Star</title>
</head>
    <body>
   <div id="msg">
    <h3>Write message</h3>
    <form method="post" action="sendstar.php?action=send">
    <input type="hidden" name="touser" value="<?php echo $html["touser"] ?>" />
    <dl>
        <dd><input type="text" class="text" readonly = "readonly" value="TO: <?php echo $html["touser"] ?>"/>
            <select name="star" >
                <?php 
                    foreach(range(1,10) as $num){
                        echo '<option value="'.$num.'">x '.$num.'</option>';
                    }
                ?>
            </select>
        </dd>
        <dd><textarea name="content">Hey, I've sent you a star ~~</textarea>
            
        </dd>
        <dd><label>Passcode</label><input type="text" name="passcode" class="passcode" />
                                        <img src="code.php" id="code" />
                                        <input type="submit" class="submit" value="Send Star" />
                                        </dd>
    </dl>
    </form>
   </div>
    </body>
</html>